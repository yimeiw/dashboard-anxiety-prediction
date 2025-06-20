<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PredictionResult;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $latestResult = PredictionResult::where('user_id', $userId)
                            ->latest()
                            ->first();

        // Ambil riwayat hasil prediksi pengguna
        $history = PredictionResult::where('user_id', $userId)
            ->orderBy('created_at')
            ->get(['created_at', 'prediction']);

        if ($latestResult) {
            $gender = $latestResult->input_data['gender'];

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

            // Pass data to view
            return view('dashboard', [
                'result' => $latestResult,
                'average' => $averages,
                'history' => $history,
            ]);
        } else {
            // Return a view with no prediction result
            return view('dashboard', ['result' => null, 'history' => $history]);
        }
    }
}
