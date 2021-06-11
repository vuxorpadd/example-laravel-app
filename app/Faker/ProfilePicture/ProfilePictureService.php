<?php

namespace App\Faker\ProfilePicture;

use App\Faker\Gender;

interface ProfilePictureService
{
    public function generateRandom(Gender $gender): string;
}
