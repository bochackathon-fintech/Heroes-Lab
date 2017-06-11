<?php

use App\UserBankAccount;
use Illuminate\Database\Seeder;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(UserBankAccount::class)->times(10000)->create();

    }
}
