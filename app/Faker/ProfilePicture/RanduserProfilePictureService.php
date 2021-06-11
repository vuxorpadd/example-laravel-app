<?php

namespace App\Faker\ProfilePicture;

use App\Faker\Gender;

class RanduserProfilePictureService extends BaseProfilePictureService
{
    public function generateRandom(Gender $gender): string
    {
        $genderSlug = (string) $gender === "male" ? "men" : "women";
        $photoId = rand(1, 99);
        return "https://randomuser.me/api/portraits/{$genderSlug}/{$photoId}.jpg";
    }
}
