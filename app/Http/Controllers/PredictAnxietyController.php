<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\PredictionResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;


class PredictAnxietyController extends Controller
{
    public function predict(Request $request)
    {
        // Ambil data dari form
        $inputData = $request->only([
            'age', 'gender', 'occupation', 'sleepHours', 'physicalActivity', 'caffeineInTake',
            'workStressLevel', 'stressLevel', 'heartRate', 'heartRateVariability',
            'cortisolLevel', 'therapySession', 'sleepQuality',
            'overthinking', 'lackOfConfidence', 'lackOfSleep', 'exerciseFrequency', 'loneliness'
        ]);

        // Kirim ke backend FastAPI
        try {
            Log::info('Sending data to FastAPI:', $inputData);

            $response = Http::post('http://127.0.0.1:8081/predict', $inputData);

            Log::info('FastAPI response:', $response->json());
            
            if ($response->successful()) {
                $result = $response->json();

                // Simpan ke database
                PredictionResult::create([
                    'user_id' => Auth::id(), // jika user login
                    'input_data' => $inputData,
                    'prediction' => $result['prediction'],
                    'suggestion' => $result['suggestion'],
                ]);

                return redirect()->route('prediction.result.view')->with('success', 'Prediksi berhasil disimpan.');
            } else {
                return back()->withErrors(['msg' => 'Failed to get prediction from backend.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Error: ' . $e->getMessage()]);
        }
    }


    public function showResult()
    {
        $latestResults = PredictionResult::where('user_id', Auth::id())
            ->latest()
            ->first();

        if (!$latestResults) {
            return view('prediction-result', ['result' => null]);
        }

        $gender = $latestResults->input_data['gender'];

        // Ambil semua input_data dari user dengan gender yang sama
        $data = PredictionResult::whereJsonContains('input_data->gender', $gender)
            ->get()
            ->pluck('input_data');

        // Ambil semua key yang ingin dihitung rata-ratanya
        $keys = [
            'overthinking', 'lackOfConfidence', 'lackOfSleep', 'exerciseFrequency',
            'loneliness', 'therapySession', 'sleepQuality', 'heartRate',
            'heartRateVariability', 'cortisolLevel', 'stressLevel', 'workStressLevel'
        ];

        // Inisialisasi array kosong untuk menghitung total
        $sums = array_fill_keys($keys, 0);
        $count = count($data);

        // Hitung total untuk tiap key
        foreach ($data as $row) {
            foreach ($keys as $key) {
                $sums[$key] += $row[$key] ?? 0;
            }
        }

        // Hitung rata-rata
        $averages = [];
        foreach ($sums as $key => $total) {
            $averages[$key] = $count > 0 ? round($total / $count, 2) : 0;
        }

        return view('prediction-result', [
            'result' => $latestResults,
            'average' => $averages
        ]);
    }



}