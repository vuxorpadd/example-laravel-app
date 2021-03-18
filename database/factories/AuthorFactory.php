<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $author = $this->faker->person;

        return [
            "name" => $author["name"],
            "birthdate" => $author["birthdate"],
            "bio" => $this->faker->text(500),
            "photo" => $author["photo"],
        ];
    }
}
