<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'username' => $faker->username,
        'password' => $faker->password,
        'photo' => $faker->image($dir = '/tmp', $width = 640, $height = 480),
        'role_id' => $faker->randomElement($array = array (1,2,3))
    ];
});
