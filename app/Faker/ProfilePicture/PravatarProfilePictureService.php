<?php

namespace App\Faker\ProfilePicture;

use App\Faker\Gender;

class PravatarProfilePictureService extends BaseProfilePictureService
{
    use HasGenderCollections;

    public function __construct()
    {
        $this->setMenIds([
            "6",
            "7",
            "8",
            "11",
            "12",
            "13",
            "14",
            "15",
            "17",
            "18",
            "50",
            "51",
            "52",
            "53",
            "54",
            "55",
            "56",
            "57",
            "58",
            "59",
            "60",
            "61",
            "62",
            "63",
            "64",
            "65",
            "66",
            "67",
            "68",
            "69",
            "70",
        ]);

        $this->setWomenIds([
            "1",
            "5",
            "9",
            "10",
            "16",
            "20",
            "21",
            "22",
            "23",
            "24",
            "25",
            "26",
            "27",
            "30",
            "31",
            "32",
            "33",
            "34",
            "35",
            "36",
            "38",
            "39",
            "40",
            "41",
            "42",
            "43",
            "44",
            "45",
            "47",
            "48",
            "49",
        ]);
    }

    public function generateRandom(Gender $gender): string
    {
        $imageId = $this->randomIdFromGenderCollection($gender);
        return "https://i.pravatar.cc/300?img={$imageId}";
    }
}
