<?php

use App\Actions\Role\DeleteRole;
use App\Models\Role;

it('deletes a role successfully', function () {
    $role = Role::factory()->create();

    $deleted = (new DeleteRole())->handle($role);

    expect($deleted)->toBeTrue()
        ->and(Role::find($role->id))->toBeNull();
});

it('does not delete a non-existent role', function () {
    $role = new Role(['id' => 999]); // Simulate a non-existent role

    $deleted = (new DeleteRole())->handle($role);

    expect($deleted)->toBeFalse();
});
