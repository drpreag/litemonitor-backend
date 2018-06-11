<?php

use Faker\Generator as Faker;

$factory->define(App\Flapping::class, function (Faker $faker) {
    return [
        'service_id' => 1,
        'host_id' => 1,
        'comment' => $faker->word
    ];
});
