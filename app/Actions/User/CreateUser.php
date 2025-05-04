<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateUser
{
    /**
     * Handle the creation of a new user.
     *
     * @param array $attributes
     * @return User
     */
    public function handle(array $attributes): User
    {
        $data = Validator::make($attributes, $this->rules())->validate();
        $data['password'] = Hash::make(Str::password());

        return User::create($data);
    }

    /**
     * Get the validation rules for creating a user.
     *
     * @return array
     */
    private function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ];
    }
}
