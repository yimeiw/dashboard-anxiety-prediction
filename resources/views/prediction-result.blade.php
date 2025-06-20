<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anxiety Prediction Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-12">
                @if($result)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Prediction Result:</h3>
                        <p class="text-gray-600">{{ $result->prediction }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Suggestion:</h3>
                        <p class="text-gray-600">{{ $result->suggestion }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Date:</h3>
                        <p class="text-gray-600">{{ $result->created_at->format('d M Y H:i') }}</p>
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        <p class="text-lg font-medium text-gray-900">No prediction history available.</p>
                        <p>Please make a prediction to see the results.</p>
                        <a href="{{ route('anxiety-prediction') }}" class="mt-4 inline-block px-6 py-3 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                            Start Predicting Now!
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
