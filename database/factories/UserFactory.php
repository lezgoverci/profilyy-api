<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $password = $faker->password;
    return [
        'account_id' => function(){
            return factory(\App\Account::class)->make()->id;
        },
        'email' => $faker->unique()->safeEmail,
        'password' => $password,
        'api_token' => hash('sha256', $password)
        

    ];
});
