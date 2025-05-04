<?php

use App\Actions\User\CreateUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

it('creates a user with valid attributes', function () {
    $attributes = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
    ];

    $user = (new CreateUser())->handle($attributes);

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->first_name)->toBe('John')
        ->and($user->last_name)->toBe('Doe')
        ->and($user->email)->toBe('john.doe@example.com')
        ->and($user->password)->toBeString()
        ->and(Hash::check('password', $user->password))->toBeFalse(); // Password should be hashed and different from default
});

it('validates required fields', function () {
    $attributes = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
    ];

    expect(fn () => (new CreateUser())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates string fields', function () {
    $attributes = [
        'first_name' => 123,
        'last_name' => 456,
        'email' => 789,
    ];

    expect(fn () => (new CreateUser())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates max length for string fields', function () {
    $attributes = [
        'first_name' => str_repeat('a', 256),
        'last_name' => str_repeat('a', 256),
        'email' => str_repeat('a', 256),
    ];

    expect(fn () => (new CreateUser())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates email format', function () {
    $attributes = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'not-an-email',
    ];

    expect(fn () => (new CreateUser())->handle($attributes))
        ->toThrow(ValidationException::class);
});

it('validates unique email', function () {
    // Create a user first
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    // Try to create another user with the same email
    $attributes = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'existing@example.com',
    ];

    expect(fn () => (new CreateUser())->handle($attributes))
        ->toThrow(ValidationException::class);
});
