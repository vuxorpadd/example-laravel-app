<?php

namespace App\Faker\ProfilePicture;

use App\Faker\Gender;
use Faker\Provider\Person;

trait HasGenderCollections
{
    private array $menIds = [];
    private array $womenIds = [];

    private function setMenIds(array $ids)
    {
        $this->menIds = $ids;
    }

    private function setWomenIds(array $ids)
    {
        $this->womenIds = $ids;
    }

    private function randomIdFromGenderCollection(Gender $gender): string
    {
        $idCollection =
            (string) $gender == Person::GENDER_MALE
                ? $this->menIds
                : $this->womenIds;

        return $idCollection[array_rand($idCollection)];
    }
}
