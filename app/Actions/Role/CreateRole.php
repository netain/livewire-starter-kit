<?php

namespace App\Actions\Role;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class CreateRole
{
    /**
     * Handle the creation of a new role.
     *
     * @param array $attributes
     * @return Role
     */
    public function handle(array $attributes): Role
    {
        $data = Validator::make($attributes, $this->rules())->validate();
        return Role::create($data);
    }

    /**
     * Get the validation rules for creating a role.
     *
     * @return array
     */
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:roles,code'],
            'is_super' => 'boolean',
        ];
    }
}
