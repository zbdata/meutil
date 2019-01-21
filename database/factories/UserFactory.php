<?php

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        "name" => $faker->name,
        "email" => $faker->safeEmail,
        "password" => str_random(10),
        "remember_token" => $faker->name,
        "matricula" => $faker->randomNumber(2),
        "almoco" => $faker->date("H:i:s", $max = 'now'),
        "cargahoraria" => $faker->date("H:i:s", $max = 'now'),
    ];
});
