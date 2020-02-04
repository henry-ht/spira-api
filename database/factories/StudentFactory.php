<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        "name"      => ($faker->firstName().' '.$faker->lastName()),
        "email"     => $faker->unique()->safeEmail,
        "phone"     => $faker->unique()->tollFreePhoneNumber,
        "course_id" => App\Models\Course::all()->random()->id,
    ];
});
