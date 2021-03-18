<?php

namespace App\Faker;

use App\Exceptions\CannotGenerateProfilePhotoException;
use Carbon\Carbon;
use Faker\Provider\Base;
use Faker\Provider\Person;
use Illuminate\Support\Facades\Http;

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
        try {
            $url = "https://fakeface.rest/face/json?gender={$gender}&minimum_age=25";
            $response = Http::get($url)->json();
        } catch (\Exception $e) {
            throw new CannotGenerateProfilePhotoException($e);
        }

        return [
            "metadata" => ["age" => $response["age"]],
            "photo" => $response["image_url"],
        ];
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
        $profilePhoto = $this->profilePhoto($gender);

        $birthdate = $this->birthdateFromAge($profilePhoto["metadata"]["age"]);

        return [
            "name" => $this->titlelessName($gender),
            "photo" => $profilePhoto["photo"],
            "birthdate" => $birthdate,
        ];
    }
}
