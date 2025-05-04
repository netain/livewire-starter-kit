<?php

use App\Actions\User\UpdateUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

it('updates a user with valid attributes', function () {
    $user = User::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
    ]);

    $attributes = [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
    ];

    $updatedUser = (new UpdateUser())->handle($user, $attributes);

    expect($updatedUser)->toBeInstanceOf(User::class)
        ->and($updatedUser->first_name)->toBe('Jane')
        ->and($updatedUser->last_name)->toBe('Smith')
        ->and($updatedUser->email)->toBe('jane.smith@example.com');
});

it('keeps existing password when not provided', function () {
    $user = User::factory()->create();
    $oldPassword = $user->password;

    $attributes = [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'email' => 'jane.smith@example.com',
    ];

    $updatedUser = (new UpdateUser())->handle($user, $attributes);

    expect($updatedUser->password)->toBe($oldPassword);
});

it('validates required fields', function () {
    $user = User::factory()->create();
    
    $attributes = [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
    ];

    expect(fn () => (new UpdateUser())->handle($user, $attributes))
        ->toThrow(ValidationException::class);
});

it('validates string fields', function () {
    $user = User::factory()->create();
    
    $attributes = [
        'first_name' => 123,
        'last_name' => 456,
        'email' => 789,
    ];

    expect(fn () => (new UpdateUser())->handle($user, $attributes))
        ->toThrow(ValidationException::class);
});

it('validates max length for string fields', function () {
    $user = User::factory()->create();
    
    $attributes = [
        'first_name' => str_repeat('a', 256),
        'last_name' => str_repeat('a', 256),
        'email' => str_repeat('a', 256),
    ];

    expect(fn () => (new UpdateUser())->handle($user, $attributes))
        ->toThrow(ValidationException::class);
});

it('validates email format', function () {
    $user = User::factory()->create();
    
    $attributes = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'not-an-email',
    ];

    expect(fn () => (new UpdateUser())->handle($user, $attributes))
        ->toThrow(ValidationException::class);
});

it('allows user to keep their existing email', function () {
    $user = User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $attributes = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'existing@example.com', // Same email as the user
    ];

    $updatedUser = (new UpdateUser())->handle($user, $attributes);

    expect($updatedUser->email)->toBe('existing@example.com');
});

it('validates unique email when changed', function () {
    // Create another user with the email we want to use
    User::factory()->create([
        'email' => 'taken@example.com',
    ]);

    $user = User::factory()->create([
        'email' => 'original@example.com',
    ]);

    $attributes = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'taken@example.com', // Email that belongs to another user
    ];

    expect(fn () => (new UpdateUser())->handle($user, $attributes))
        ->toThrow(ValidationException::class);
});
