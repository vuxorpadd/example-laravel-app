<?php

namespace App\Faker;

use Faker\Provider\Base;

class CustomFakerProvider extends Base
{
    public function bookName(): string
    {
        return ucfirst(
            $this->generator->words($this->generator->numberBetween(1, 3), true)
        );
    }
}
