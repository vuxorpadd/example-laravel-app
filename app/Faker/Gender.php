<?php

namespace App\Faker;

use App\Faker\Exceptions\WrongGenderException;
use Faker\Provider\Person;

class Gender
{
    private static array $supportedGenders = [
        Person::GENDER_MALE,
        Person::GENDER_FEMALE,
    ];

    private string $value;

    public function __construct(string $value)
    {
        if (!in_array($value, self::$supportedGenders)) {
            throw new WrongGenderException(
                $value . "is not a supported gender"
            );
        }

        $this->value = $value;
    }

    public static function random(): self
    {
        return new self(
            self::$supportedGenders[array_rand(self::$supportedGenders)]
        );
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
