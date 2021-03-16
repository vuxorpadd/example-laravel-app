<?php

namespace App\Faker;

use Faker\Factory;
use Faker\Generator;

class CustomFakerFactory
{
    public function create(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomFakerProvider($faker));
        return $faker;
    }
}
