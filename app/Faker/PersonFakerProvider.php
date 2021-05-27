<?php

namespace App\Faker;

use App\Exceptions\CannotGenerateProfilePhotoException;
use Carbon\Carbon;
use Faker\Provider\Base;
use Faker\Provider\Person;

class PersonFakerProvider extends Base
{
    private array $genders = [Person::GENDER_MALE, Person::GENDER_FEMALE];

    /**
     * @param string $gender
     * @return mixed
     * @throws CannotGenerateProfilePhotoException
     */
    private function profilePhoto(string $gender = Person::GENDER_MALE)
    {
        $genderSlug = $gender === "male" ? "men" : "women";
        $photoId = rand(1, 99);
        return "https://randomuser.me/api/portraits/{$genderSlug}/{$photoId}.jpg";
    }

    private function birthday(): string
    {
        $age = rand(15, 100);
        return $this->birthdateFromAge($age);
    }

    private function birthdateFromAge(int $age): string
    {
        $birthDay = $this->generator->date("m-d");
        $birthYear = Carbon::now()->subYears($age)->year;

        return "$birthYear-$birthDay";
    }

    public function titlelessName(string $gender = Person::GENDER_MALE)
    {
        return $this->generator->firstName($gender) .
            " " .
            $this->generator->lastName;
    }

    /**
     * @return array
     * @throws CannotGenerateProfilePhotoException
     */
    public function person(): array
    {
        $gender = $this->generator->randomElement($this->genders);

        return [
            "name" => $this->titlelessName($gender),
            "photo" => $this->profilePhoto($gender),
            "birthdate" => $this->birthday(),
        ];
    }
}
