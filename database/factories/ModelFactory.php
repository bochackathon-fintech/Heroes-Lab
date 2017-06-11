<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'interledger_password' => $password ?: $password = bcrypt('secret'),
        'channel_id' => $faker->unique()->numberBetween(),
        'user_id' => $faker->unique()->numberBetween(),
        'is_locked' => $faker->boolean(2),
        'remember_token' => str_random(10),
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
        'deleted_at' => null
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'bank_account_id' => function () {
            return factory(App\UserBankAccount::class)->create()->id;
        },
        'category' => $faker->randomElement(['Food', 'Leisure', 'Clothing', 'Gas', 'Electronics']),
        'to_user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'amount' => $faker->randomNumber(8),
        'balance' => $faker->numberBetween(),
        'status' => $faker->randomElement(['pending', 'completed']),
        'verification_number' => $faker->uuid,
        'created_at' => $faker->dateTimeThisYear,
        'updated_at' => $faker->dateTimeThisYear,
    ];
});


$factory->define(App\UserBankAccount::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'account_id' => $faker->randomNumber(),
        'swift' => $faker->swiftBicNumber,
        'iban' => $faker->iban(),
        'auth_provider_name' => $faker->unique()->uuid,
        'auth_id' => $faker->unique()->uuid,
        'auth_token_key' => $faker->unique()->uuid,
        'balance' => $faker->numberBetween(),
    ];
});
