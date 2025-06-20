<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Str;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'username' => ['required', 'string', 'max:255', 'regex:/^\w+$/'],
            'phone' => ['required', 'string', 'regex:/^\+62[0-9]{9,14}$/', 'unique:users,phone'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        
        $formattedPhone = $this->formatPhone($input['phone']);

        return User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'phone' => $formattedPhone,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }

    private function formatPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (Str::startsWith($phone, '0')) {
            return '+62' . substr($phone, 1);
        }

        if (Str::startsWith($phone, '62')) {
            return '+'.$phone;
        }

        return $phone;
    }
}
