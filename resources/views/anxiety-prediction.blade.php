<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Anxiety Prediction') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="p-5 text-gray-900">
                    {{ __('Please input your data!') }}
                </div>


                <form action="{{ route('prediction.result') }}" method="post" class="p-2">
                    @csrf
                    <div class="flex flex-row justify-between gap-x-4 gap-y-2">

                        <!-- Left Column -->
                        <div class="w-1/2 p-6">
                            <div class="mb-8">
                                <label for="age" class="block text-gray-700 text-sm font-bold mb-2">Age:</label>
                                <input type="number" name="age" id="age" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-8">
                                <label for="gender" class="block text-gray-700 text-sm font-bold mb-2">Gender:</label>
                                <select name="gender" id="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>


                            <div class="mb-8">
                                <label for="occupation" class="block text-gray-700 text-sm font-bold mb-2">Occupation:</label>
                                <select name="occupation" id="occupation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your occupation</option>
                                    <option value="Doctor">Doctor</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Student">Student</option>
                                    <option value="Teache">Teacher</option>
                                    <option value="Unemployed">Unemployed</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>


                            <div class="mb-8">
                                <label for="sleepHours" class="block text-gray-700 text-sm font-bold mb-2">How many hours do you sleep each night on average?</label>
                                <input type="number" step="0.1" name="sleepHours" id="sleepHours" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ex: 1.5 (1 hours 5 minute)" required>
                            </div>


                            <div class="mb-8">
                                <label for="physicalActivity" class="block text-gray-700 text-sm font-bold mb-2">How many hours of physical activity do you do in a typical week?</label>
                                <input type="number" step="0.1" name="physicalActivity" id="physicalActivity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ex: 1.5 (1 hours 5 minute)" required>
                            </div>

                            <div class="mb-8">
                                <label for="caffeineInTake" class="block text-gray-700 text-sm font-bold mb-2">How many caffeinated drinks do you consume per day?</label>
                                <input type="number" name="caffeineInTake" id="caffeineInTake" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-8">
                                <label for="workStressLevel" class="block text-gray-700 text-sm font-bold mb-2">Rate your work-related stress (1–12).</label>
                                <select name="workStressLevel" id="workStressLevel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your work stress level</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="stressLevel" class="block text-gray-700 text-sm font-bold mb-2">Rate your general stress level (1–9).</label>
                                <select name="stressLevel" id="stressLevel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your stress level</option>
                                    @for($i = 1; $i <= 9; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="heartRate" class="block text-gray-700 text-sm font-bold mb-2">What is your average heart rate (bpm)?</label>
                                <input type="number" name="heartRate" id="heartRate" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>

                            <div class="mb-8">
                                <label for="heartRateVariability" class="block text-gray-700 text-sm font-bold mb-2">What is your HRV value (ms)?</label>
                                <input type="number" name="heartRateVariability" id="heartRateVariability" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="w-1/2 p-6">
                            <div class="mb-8">
                                <label for="cortisolLevel" class="block text-gray-700 text-sm font-bold mb-2">Rate your cortisol level (1–5).</label>
                                <select name="cortisolLevel" id="cortisolLevel" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your cortisol level</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>


                            <div class="mb-8">
                                <label for="therapySession" class="block text-gray-700 text-sm font-bold mb-2">How many therapy sessions have you had in the last month?</label>
                                <input type="number" name="therapySession" id="therapySession" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>


                            <div class="mb-8">
                                <label for="sleepQuality" class="block text-gray-700 text-sm font-bold mb-2">Rate your sleep quality (1–10).</label>
                                <select name="sleepQuality" id="sleepQuality" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your sleep quality</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="gadScale" class="block text-gray-700 text-sm font-bold mb-2">Input your GAD score (scale: 0–21).</label>
                                <select name="gadScale" id="gadScale" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your GAD score</option>
                                    @for($i = 0; $i <= 21; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>


                            <div class="mb-8">
                                <label for="overthinking" class="block text-gray-700 text-sm font-bold mb-2">How often do you overthink? (1–10)</label>
                                <select name="overthinking" id="overthinking" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your overthinking frequency</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="lackOfConfidence" class="block text-gray-700 text-sm font-bold mb-2">How confident are you? (1 = very confident, 10 = not confident)</label>
                                <select name="lackOfConfidence" id="lackOfConfidence" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your lack of confidence scale</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="lackOfSleep" class="block text-gray-700 text-sm font-bold mb-2">How much do you feel sleep-deprived? (1–10)</label>
                                <select name="lackOfSleep" id="lackOfSleep" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your lack of sleep scale</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="exerciseFrequency" class="block text-gray-700 text-sm font-bold mb-2">How often do you exercise? (1 = never, 10 = very often)</label>
                                <select name="exerciseFrequency" id="exerciseFrequency" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your exercise frequency</option>
                                    @for($i = 0; $i < 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-8">
                                <label for="loneliness" class="block text-gray-700 text-sm font-bold mb-2">How lonely do you feel? (1 = not at all, 10 = extremely)</label>
                                <select name="loneliness" id="loneliness" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="" disabled selected>Select your loneliness scale</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end p-3 mt-4">
                        <button type="submit" class="border-blue-1 bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded focus:outline-none">
                            Submit
                        </button>
                    </div>


                </form>

            </div>
        </div>
    </div>
</x-app-layout>
