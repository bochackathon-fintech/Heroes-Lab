<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        // $this->call(TransactionsTableSeeder::class);
        //$this->call(AccountsTableSeeder::class);
        $users = factory(User::class, 10)
            ->create()
            ->each(function (User $user) {
                // $user->bankAccounts()->save(factory(App\UserBankAccount::class)->create(['user_id' => $user->id]));
                $transactions = factory(App\Transaction::class, 1000)->create(['user_id' => $user->id]);
                $user->transactions()->saveMany($transactions);
            });
    }
}
