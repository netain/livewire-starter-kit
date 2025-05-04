<?php

namespace App\Actions\Role;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class UpdateRole
{
    /**
     * Handle the update of a role.
     *
     * @param Role $role
     * @param array $attributes
     * @return bool
     */
    public function handle(Role $role, array $attributes): bool
    {
        $data = Validator::make($attributes, $this->rules($role))->validate();
        $updated = false;
        $role->fill($data);

        if($role->isDirty()) {
            $updated = $role->save();
        }

        // TODO: Clean relations (permissions)
        // TODO: Update relations (permissions)
        return $updated;
    }

    /**
     * Get the validation rules for updating a role.
     *
     * @param Role $role
     * @return array
     */
    private function rules(Role $role): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:roles,code,' . $role->id],
            'is_super' => 'boolean',
        ];
    }
}
