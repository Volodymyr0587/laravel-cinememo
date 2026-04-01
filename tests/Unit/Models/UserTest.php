<?php

use App\Models\User;

it('returns properly formatted user initials', function () {
    $users = User::factory()
        ->count(2)
        ->sequence(
            ['name' => 'John Doe'],
            ['name' => 'David']
        )->create();

    expect($users[0]->initials())->toEqual('JD');
    expect($users[1]->initials())->toEqual('D');
});
