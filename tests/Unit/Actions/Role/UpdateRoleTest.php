<?php

use App\Actions\Role\UpdateRole;
use App\Models\Role;
use Illuminate\Validation\ValidationException;

it('updates a role with valid attributes', function () {
    $role = Role::factory()->create();

    $attributes = [
        'name' => 'Updated Role',
        'code' => 'updated-role',
        'is_super' => true,
    ];

    $updated = (new UpdateRole())->handle($role, $attributes);

    expect($updated)->toBeTrue()
        ->and($role->refresh()->name)->toBe('Updated Role')
        ->and($role->code)->toBe('updated-role')
        ->and($role->is_super)->toBeTrue();
});

it('validates required fields', function () {
    $role = Role::factory()->create();

    $attributes = [
        'name' => '',
        'code' => '',
    ];

    expect(fn () => (new UpdateRole())->handle($role, $attributes))
        ->toThrow(ValidationException::class);
});

it('validates unique code', function () {
    $existingRole = Role::factory()->create(['code' => 'existing-role']);
    $role = Role::factory()->create();
    $attributes = [
        'name' => 'New Role',
        'code' => $existingRole->code,
    ];
    expect(fn () => (new UpdateRole())->handle($role, $attributes))
    ->toThrow(ValidationException::class);
});

it('validates string fields', function () {
    $role = Role::factory()->create();

    $attributes = [
        'name' => 123,
        'code' => 456,
        'is_super' => 'not-a-boolean',
    ];

    expect(fn () => (new UpdateRole())->handle($role, $attributes))
        ->toThrow(ValidationException::class);
});

it('validates max length for string fields', function () {
    $role = Role::factory()->create();

    $attributes = [
        'name' => str_repeat('a', 256),
        'code' => str_repeat('a', 256),
    ];

    expect(fn () => (new UpdateRole())->handle($role, $attributes))
        ->toThrow(ValidationException::class);
});
