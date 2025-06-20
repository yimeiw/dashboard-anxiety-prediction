<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"  required autofocus autocomplete="name" pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi" />
                <small id="name-error" class="text-red-500 text-sm hidden">Hanya boleh huruf dan spasi</small>
            </div>

            <div>
                <x-label for="username" value="{{ __('Username') }}" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                <small id="username-error" class="text-red-500 text-sm hidden">Username hanya boleh huruf, angka, dan garis bawah</small>
            </div>

            <div>
                <x-label for="phone" value="{{ __('Phone Number') }}" />
                <x-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required autofocus autocomplete="phone" />
                <small id="phone-error" class="text-red-500 text-sm hidden">Nomor harus diawali +62 dan hanya berisi angka</small>
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <small id="email-error" class="text-red-500 text-sm hidden">Format email tidak valid</small>
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <small id="password-error" class="text-red-500 text-sm hidden">Minimal 8 karakter, kombinasi huruf dan angka</small>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>

    @push('scripts')
    <script>
        console.log('JS Loaded!')
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            const usernameInput = document.getElementById('username');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            const nameError = document.getElementById('name-error');
            const usernameError = document.getElementById('username-error');
            const phoneError = document.getElementById('phone-error');
            const emailError = document.getElementById('email-error');
            const passwordError = document.getElementById('password-error');

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Nama: hanya huruf dan spasi
            nameInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
                nameError.classList.add('hidden');
            });

            // Username: huruf, angka, underscore
            usernameInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '');
                usernameError.classList.add('hidden');
            });

            // Phone: wajib diawali +62 dan hanya angka setelahnya
            phoneInput.addEventListener('input', function () {
                if (!this.value.startsWith('+62')) {
                    this.value = '+62';
                } else {
                    this.value = '+62' + this.value.slice(3).replace(/[^0-9]/g, '');
                }
                phoneError.classList.add('hidden');
            });

            // Email: hanya karakter valid
            emailInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-zA-Z0-9@._\-+]/g, '');
                if (emailRegex.test(this.value)) {
                    emailError.classList.add('hidden');
                }
            });

            // Password: hanya huruf dan angka, validasi panjang + kombinasi huruf & angka
            passwordInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
                const isValid = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(this.value);
                passwordError.classList.toggle('hidden', isValid);
            });

            // Validasi tambahan saat blur (optional, untuk muncul pesan error kalau tetap salah)
            nameInput.addEventListener('blur', function () {
                if (!/^[a-zA-Z\s]+$/.test(this.value)) nameError.classList.remove('hidden');
            });

            usernameInput.addEventListener('blur', function () {
                if (!/^[a-zA-Z0-9_]+$/.test(this.value)) usernameError.classList.remove('hidden');
            });

            phoneInput.addEventListener('blur', function () {
                if (!/^\+62[0-9]{9,15}$/.test(this.value)) phoneError.classList.remove('hidden');
            });

            emailInput.addEventListener('blur', function () {
                if (!emailRegex.test(this.value)) emailError.classList.remove('hidden');
            });

            passwordInput.addEventListener('blur', function () {
                if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(this.value)) {
                    passwordError.classList.remove('hidden');
                }
            });

            // Mencegah paste di input tertentu
            [nameInput, usernameInput, phoneInput].forEach(input => {
                input.addEventListener('paste', e => e.preventDefault());
            });
        });
    </script>
    @endpush




</x-guest-layout>
