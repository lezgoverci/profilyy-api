<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'address' => $faker->address,
        'phone' => $faker->tollFreePhoneNumber,
        'gender' => $faker->randomElement($array = array('male','female')),
        'photo' => $faker->image($dir = '/tmp', $width = 640, $height = 480)
    ];
});
