<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->bookName,
            "subtitle" => $this->faker->sentence(
                $this->faker->numberBetween(3, 7)
            ),
            "description" => $this->faker->text(300),
            "preview" => $this->faker->realText(1000, 3),
            "cover" => $this->faker->imageUrl(200, 300, true),
        ];
    }
}
