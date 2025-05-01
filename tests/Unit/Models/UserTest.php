<?php

use App\Models\User;

test('to array', function (): void {
    $user = User::factory()->create();
    expect($user->toArray())->toHaveKeys([
        'first_name',
        'last_name',
        'email',
        'accepted_at'
    ]);
});

it('can be accepted', function(): void {
    $user = User::factory()->accepted()->create();

    expect($user->accepted_at)->not()->toBeNull();
});
