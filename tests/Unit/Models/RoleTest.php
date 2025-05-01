<?php

use App\Models\Role;

test('to array', function () {
    $role = Role::factory()->create();

    expect($role->toArray())->toHaveKeys([
        'code',
        'name',
        'is_super',
    ]);
});

it('can be a super', function () {
    $role = Role::factory()->super()->create();

    expect($role->is_super)->toBeTrue();
});

it('has many users', function () {
    $role = Role::factory()->users(3)->create();

    expect($role->users)->tohaveCount(3);
});
