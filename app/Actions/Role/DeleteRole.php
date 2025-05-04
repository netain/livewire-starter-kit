<?php

namespace App\Actions\Role;

use App\Models\Role;
use Illuminate\Support\Facades\Validator;

class DeleteRole
{
    /**
     * Handle the deletion of a role.
     *
     * @param Role $role
     * @return bool
     */
    public function handle(Role $role): bool
    {
        if(!$role->exists) {
            return false;
        }

        return $role->delete();
    }
}
