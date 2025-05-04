<?php

use App\Actions\Role\CreateRole;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

it('creates a role with valid attributes', function () {
    $attributes = [
        'name' => 'Test Role',
        'code' => 'test-role',
        'is_super' => false,
    ];

    $role = (new CreateRole())->handle($attributes);

    expect($role)->toBeInstanceOf(Role::class)
        ->and($role->name)->toBe('Test Role')
        ->and($role->code)->toBe('test-role')
        ->and($role->is_super)->toBeFalse();
});

it('creates a super role', function () {
    $attributes = [
        'name' => 'Super Role',
        'code' => 'super-role',
        'is_super' => true,
    ];

    $role = (new CreateRole())->handle($attributes);

    expect($role->is_super)->toBeTrue();
});

it('validates required fields', function () {
    $attributes = [
        'name' => '',
        'code' => '',
    ];

    expect(fn () => (new CreateRole())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates unique code', function () {
    // Create a role first
    Role::create([
        'name' => 'Existing Role',
        'code' => 'existing-role',
        'is_super' => false,
    ]);

    // Try to create another role with the same code
    $attributes = [
        'name' => 'New Role',
        'code' => 'existing-role',
        'is_super' => false,
    ];

    expect(fn () => (new CreateRole())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates string fields', function () {
    $attributes = [
        'name' => 123,
        'code' => 456,
        'is_super' => 'not-a-boolean',
    ];

    expect(fn () => (new CreateRole())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates max length for string fields', function () {
    $attributes = [
        'name' => str_repeat('a', 256),
        'code' => str_repeat('a', 256),
        'is_super' => false,
    ];

    expect(fn () => (new CreateRole())->handle($attributes))
        ->toThrow(ValidationException::class);
});
