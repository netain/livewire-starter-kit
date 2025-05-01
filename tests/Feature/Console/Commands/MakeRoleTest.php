<?php

it('creates a new role', function () {
    $roleName = 'TestRole';
    $this->artisan("make:role {$roleName}")
        ->expectsOutput("Role {$roleName} created successfully.");

    $this->assertDatabaseHas('roles', [
        'name' => $roleName,
    ]);
});

it('creates a new role with super', function () {
    $roleName = 'TestRole';
    $this->artisan("make:role --super {$roleName}")
        ->expectsOutput("Role {$roleName} created successfully.");

    $this->assertDatabaseHas('roles', [
        'name' => $roleName,
        'is_super' => true,
    ]);
});
