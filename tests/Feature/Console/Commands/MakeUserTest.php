<?php

it('creates a new user', function () {
    $this->artisan('make:user')
        ->expectsOutput('Creating a new user...')
        ->expectsQuestion('What is the first name of the user?', 'John')
        ->expectsQuestion('What is the last name of the user?', 'Doe')
        ->expectsQuestion('What is the email of the user?', 'jdoe@example.com')
        ->expectsChoice('What is the role of the user?', 'admin', ['admin', 'user'])
        ->expectsOutput('User created successfully.');
});
