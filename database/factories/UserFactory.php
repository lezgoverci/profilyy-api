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
    $token = Str::random(60);
    return [
        'account_id' => null,
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->password,
        'api_token' =>  $token
        

    ];
});
