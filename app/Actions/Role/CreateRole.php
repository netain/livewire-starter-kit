<?php

namespace App\Actions\Role;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class CreateRole
{
    public function handle(array $attributes): Role
    {
        $data = Validator::make($attributes, [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:roles,code'],
            'is_super' => 'boolean',
        ])->validate();
        return Role::create($data);
    }
}
