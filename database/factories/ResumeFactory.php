<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Resume;
use Faker\Generator as Faker;

$factory->define(Resume::class, function (Faker $faker) {
    return [
        'applicant_id' => $faker->randomDigit,
        'experience' => $faker->paragraphs($nb = 3, $asText = true),
        'education' => $faker->paragraphs($nb = 3, $asText = true),
        'skills' => $faker->paragraphs($nb = 3, $asText = true)

    ];
});
