<?php

namespace App\Faker;

use Bluemmb\Faker\PicsumPhotosProvider;
use Faker\Factory;
use Faker\Generator;

class CustomFakerFactory
{
    public function create(): Generator
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomFakerProvider($faker));
        $faker->addProvider(new PicsumPhotosProvider($faker));
        return $faker;
    }
}
