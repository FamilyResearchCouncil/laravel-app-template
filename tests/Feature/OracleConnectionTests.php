<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

it('can query the oracle dbs', function () {
    $res = DB::connection('devfrc')->getPdo();

    $this->assertInstanceOf(PDO::class, $res, 'Hey, McFLY... Are you connected to the VPN?');
});


it('can create an account record', function () {
    // show the difference between collections and arrays
    \Frc\Oracle\Models\Frc\Account::create([
        'username' => 'test',
        'password' => 'test',
        'email' => '',
        'first_name' => '',
    ]);

    $this->assertDatabaseHas('account', [
        'username' => 'test',
        'password' => 'test',
        'email' => '',
        'first_name' => '',
    ]);

});