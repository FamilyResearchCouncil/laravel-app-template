<?php

use Frc\Oracle\Models\Frc\Account;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

it('can query the oracle dbs', function () {
    $res = DB::connection('devfrc')->getPdo();

    $this->assertInstanceOf(PDO::class, $res, 'Hey, McFLY... Are you connected to the VPN?');
});


it('can create an account record', function () {
    // show the difference between collections and arrays
    $account = Account::create([
        'account_name'       => 'name',
        'account_first_name' => 'name',
        'account_familiar'   => 'name',
        'account_type'       => \Frc\Oracle\Models\Frc\AccountType::first()->account_type,
        'user_id'            => 'API_TEST',
    ]);

    $this->assertDatabaseHas('account',
        $account->toArray(),
        'frc');

});