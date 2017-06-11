<?php

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
        factory(App\Transaction::class, 1000)->create();
        //$this->call(UsersTableSeeder::class);
        // $this->call(TransactionsTableSeeder::class);
        //$this->call(AccountsTableSeeder::class);
//        $users = factory(App\User::class, 100)
//            ->create()
//            ->each(function (User $user) {
//                $user->bankAccounts()->save(factory(App\UserBankAccount::class)->create(['user_id' => $user->id]));
//                $user->transactions()->save(factory(App\Transaction::class)->create(['user_id' => $user->id]));
//            });
    }
}
