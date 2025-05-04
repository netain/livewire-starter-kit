<?php

use App\Models\Role;
use App\Models\User;

it('creates a new user', function () {
    // Create a role first since the command needs it
    $role = Role::factory()->create();
    $roles = Role::all()->pluck('code')->toArray();

    $this->artisan('make:user')
        ->expectsQuestion('What is the first name of the user?', 'John')
        ->expectsQuestion('What is the last name of the user?', 'Doe')
        ->expectsQuestion('What is the email of the user?', 'john.doe@example.com')
        ->expectsChoice('What is the role of the user?', $role->code, $roles)
        ->expectsOutput('User created successfully.');

    $this->assertDatabaseHas('users', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@example.com',
        'role_id' => $role->id,
    ]);
});

it('validates required fields', function () {
    $role = Role::factory()->create();

    $this->artisan('make:user')
        ->expectsQuestion('What is the first name of the user?', '')
        ->expectsQuestion('What is the last name of the user?', '')
        ->expectsQuestion('What is the email of the user?', '')
        ->expectsChoice('What is the role of the user?', $role->code, [$role->code])
        ->assertFailed();

    $this->assertDatabaseMissing('users', [
        'first_name' => '',
        'last_name' => '',
        'email' => '',
    ]);
})->throws(\Illuminate\Validation\ValidationException::class);

it('validates email format', function () {
    $role = Role::factory()->create();

    $this->artisan('make:user')
        ->expectsQuestion('What is the first name of the user?', 'John')
        ->expectsQuestion('What is the last name of the user?', 'Doe')
        ->expectsQuestion('What is the email of the user?', 'not-an-email')
        ->expectsChoice('What is the role of the user?', $role->code, [$role->code])
        ->assertFailed();

    $this->assertDatabaseMissing('users', [
        'email' => 'not-an-email',
    ]);
})->throws(\Illuminate\Validation\ValidationException::class);

it('validates unique email', function () {
    $role = Role::factory()->create();

    // Create a user first
    User::factory()->create([
        'email' => 'existing@example.com',
    ]);

    $this->artisan('make:user')
        ->expectsQuestion('What is the first name of the user?', 'John')
        ->expectsQuestion('What is the last name of the user?', 'Doe')
        ->expectsQuestion('What is the email of the user?', 'existing@example.com')
        ->expectsChoice('What is the role of the user?', $role->code, [$role->code])
        ->assertFailed();

    $this->assertDatabaseCount('users', 1);
})->throws(\Illuminate\Validation\ValidationException::class);
