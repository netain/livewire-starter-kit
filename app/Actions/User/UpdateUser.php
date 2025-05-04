<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UpdateUser
{
    /**
     * Handle the update of a user.
     *
     * @param User $user
     * @param array $attributes
     * @return User
     */
    public function handle(User $user, array $attributes): User
    {
        $data = Validator::make($attributes, $this->rules($user))->validate();
        $user->fill($data);
        if($user->isDirty()){
            $user->save();
        }

        return $user->fresh();
    }

    /**
     * Get the validation rules for updating a user.
     *
     * @param User $user
     * @return array
     */
    private function rules(User $user): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];
    }
}
