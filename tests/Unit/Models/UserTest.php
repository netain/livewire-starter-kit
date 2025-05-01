<?php

use App\Models\User;

test('to array', function (): void {
    $user = User::factory()->create();
    expect($user->toArray())->toHaveKeys([
        'first_name',
        'last_name',
        'email',
        'invitation_accepted_at'
    ]);
});

it('can have accepted invitation', function(): void {
    $user = User::factory()->invitation_accepted()->create();

    expect($user->invitation_accepted)->toBeTrue();
});
