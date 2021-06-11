<?php

namespace App\Faker;

use App\Faker\Exceptions\CannotGenerateProfilePhotoException;
use App\Faker\ProfilePicture\ProfilePictureService;
use Carbon\Carbon;
use Faker\Generator;
use Faker\Provider\Base;

class PersonFakerProvider extends Base
{
    private ProfilePictureService $profilePictureService;

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);

        $this->profilePictureService = app(ProfilePictureService::class);
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

    public function titlelessName(Gender $gender)
    {
        return $this->generator->firstName((string) $gender) .
            " " .
            $this->generator->lastName;
    }

    /**
     * @return array
     * @throws CannotGenerateProfilePhotoException
     */
    public function person(): array
    {
        $gender = Gender::random();

        return [
            "name" => $this->titlelessName($gender),
            "photo" => $this->profilePictureService->generateRandom($gender),
            "birthdate" => $this->birthday(),
        ];
    }
}
