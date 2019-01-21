<?php

$factory->define(App\ControleDoPonto::class, function (Faker\Generator $faker) {
    return [
        "data" => $faker->date("d/m/Y", $max = 'now'),
        "falta" => 0,
        "feriado" => 0,
        "matricula_id" => factory('App\User')->create(),
    ];
});
