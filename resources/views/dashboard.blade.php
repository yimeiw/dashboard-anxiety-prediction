<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to the Anxiety Prediction Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($result)
                    <h2 class="text-lg font-bold text-gray-900 mb-10">Graphical Prediction Results</h2>

                    <div class="flex flex-row gap-4">
                        <!-- First column -->
                        <div class="flex-1">

                            <div class="w-full border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-lg hover:border-indigo-500 transition duration-300">
                                <p class="text-md font-medium text-gray-900 mt-6">Anxiety Prediction Trend</p>
                                <p class="text-sm text-gray-600 mb-6">Shows how your anxiety level has changed over time based on previous prediction results.</p>
                                <canvas id="trendChart" class="mt-4 w-full h-auto"></canvas>
                            </div>

                            <div class="w-full mt-6 border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-lg hover:border-indigo-500 transition duration-300">
                                <p class="text-md font-thin text-gray-900 mt-6">Lifestyle Factor Chart:</p>
                                <p class="text-sm text-gray-600 mb-6">Displays the impact of each lifestyle and psychological factor on your anxiety level.</p>
                                <canvas id="radarChart" class="mt-4 w-full h-auto"></canvas>
                            </div>

                        </div>
                        <!-- Second column -->
                        <div class="flex-1">
                            <div class="w-full border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:border-indigo-500 transition duration-300">
                                <p class="text-md font-thin text-gray-900 mt-6">Top Risk Factors:</p>
                                <p class="text-sm text-gray-600 mb-6">Displays the top 5 factors with the highest values that significantly contribute to your anxiety.</p>
                                <canvas id="topFactorsChart" class="mt-4 w-full h-auto"></canvas>
                            </div>

                            <div class="w-full mt-6 border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-lg hover:border-indigo-500 transition duration-300">
                                <p class="text-md font-thin text-gray-900 mt-6">Comparison with Average Gender ({{ $result->input_data['gender'] ?? 'N/A' }})</p>
                                <p class="text-sm text-gray-600 mb-6">This chart compares your risk profile with the average of users with the same gender.</p>
                                <canvas id="comparisonChart" class="mt-4 w-full h-auto"></canvas>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="text-center mt-6">
                        <p class="text-lg text-gray-700 mb-4">No prediction result available.</p>
                        <a href="{{ route('anxiety-prediction') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                            Start Predicting Now!
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @php
        $trendData = $history->map(function($item) {
            return [
                'date' => $item->created_at->format('Y-m-d'),
                'level' => $item->prediction,
            ];
        });
    @endphp

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if ($result)
    <script>
        // Map label to numeric values for visualization
        const levelMap = {
            "Low": 1,
            "Medium": 2,
            "High": 3
        };

        const trendData = @json($trendData);
        const trendLabels = trendData.map(item => item.date);
        const trendValues = trendData.map(item => levelMap[item.level]);

        const ctx4 = document.getElementById('trendChart').getContext('2d');
        new Chart(ctx4, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Anxiety Level',
                    data: trendValues,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 5
                }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return Object.keys(levelMap).find(key => levelMap[key] === value);
                            },
                            stepSize: 1,
                            min: 1,
                            max: 3
                        },
                        title: {
                            display: true,
                            text: 'Anxiety Level'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Anxiety Prediction Trend Over Time'
                    }
                }
            }
        });

        const inputData = @json($result->input_data);

        const radarLabels = [
            "Overthinking", "Lack of Confidence", "Lack of Sleep",
            "Exercise Frequency", "Loneliness", "Therapy Sessions",
            "Sleep Quality", "Heart Rate", "Heart Rate Variability",
            "Cortisol Level", "Stress Level", "Work Stress Level"
        ];
        const radarData = [
            inputData.overthinking, inputData.lackOfConfidence, inputData.lackOfSleep,
            inputData.exerciseFrequency, inputData.loneliness, inputData.therapySession,
            inputData.sleepQuality, inputData.heartRate, inputData.heartRateVariability,
            inputData.cortisolLevel, inputData.stressLevel, inputData.workStressLevel
        ];

        const ctx = document.getElementById('radarChart').getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: radarLabels,
                datasets: [{
                    label: 'Your Scores',
                    data: radarData,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgb(59, 130, 246)',
                    pointBackgroundColor: 'rgb(59, 130, 246)'
                }],
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Anxiety Risk Profile'
                    }
                }
            }
        });

        const factorMap = {
            "Overthinking": inputData.overthinking,
            "Lack of Confidence": inputData.lackOfConfidence,
            "Lack of Sleep": inputData.lackOfSleep,
            "Exercise Frequency": inputData.exerciseFrequency,
            "Loneliness": inputData.loneliness,
            "Therapy Sessions": inputData.therapySession,
            "Sleep Quality": inputData.sleepQuality,
            "Heart Rate": inputData.heartRate,
            "Heart Rate Variability": inputData.heartRateVariability,
            "Cortisol Level": inputData.cortisolLevel,
            "Stress Level": inputData.stressLevel,
            "Work Stress Level": inputData.workStressLevel
        };

        const topFactors = Object.entries(factorMap)
            .sort((a, b) => b[1] - a[1])
            .slice(0, 5);

        const ctx3 = document.getElementById('topFactorsChart').getContext('2d');
        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: topFactors.map(f => f[0]),
                datasets: [{
                    label: 'Factor Score',
                    data: topFactors.map(f => f[1]),
                    backgroundColor: '#6366F1'
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 Highest Risk Factors'
                    }
                },
                indexAxis: 'y'
            }
        });

        const userInput = @json($result->input_data);
        const avgInput = @json($average);

        const labels = [
            "Overthinking", "Lack of Confidence", "Lack of Sleep",
            "Exercise Frequency", "Loneliness", "Therapy Sessions",
            "Sleep Quality", "Heart Rate", "Heart Rate Variability",
            "Cortisol Level", "Stress Level", "Work Stress Level"
        ];

        const userValues = [
            userInput.overthinking, userInput.lackOfConfidence, userInput.lackOfSleep,
            userInput.exerciseFrequency, userInput.loneliness, userInput.therapySession,
            userInput.sleepQuality, userInput.heartRate, userInput.heartRateVariability,
            userInput.cortisolLevel, userInput.stressLevel, userInput.workStressLevel
        ];

        const avgValues = [
            avgInput.overthinking, avgInput.lackOfConfidence, avgInput.lackOfSleep,
            avgInput.exerciseFrequency, avgInput.loneliness, avgInput.therapySession,
            avgInput.sleepQuality, avgInput.heartRate, avgInput.heartRateVariability,
            avgInput.cortisolLevel, avgInput.stressLevel, avgInput.workStressLevel
        ];

        const ctx2 = document.getElementById('comparisonChart').getContext('2d');
        new Chart(ctx2, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Your Scores',
                        data: userValues,
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgb(59, 130, 246)',
                        pointBackgroundColor: 'rgb(59, 130, 246)'
                    },
                    {
                        label: 'Population Average',
                        data: avgValues,
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgb(16, 185, 129)',
                        pointBackgroundColor: 'rgb(16, 185, 129)'
                    }
                ]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Risk Profile Comparison'
                    }
                }
            }
        });
    </script>
    @endif
</x-app-layout>
