<?php

namespace App\Faker\ProfilePicture;

use App\Faker\Gender;

class UnsplashProfilePictureService extends BaseProfilePictureService
{
    use HasGenderCollections;

    public function __construct()
    {
        $this->setMenIds([
            "DItYlc26zVI",
            "6GgCyNnF6Zs",
            "eiUBloGVHW4",
            "fulXPsSyTXc",
            "slwxJCmwHPY",
            "ILip77SbmOE",
            "SdCaK9YKdwk",
            "Ace9TRwYwU0",
            "D9HRdD46K0o",
            "y9L5-wmifaY",
            "g7oN-4RMV_M",
            "kWm6bXPJl4s",
            "HMny8cYPl4Y",
            "hAnMkbSsDMs",
            "eSjmZW97cH8",
            "fIM5oAdHAxE",
            "LQN4KLOAwYo",
            "DAMd1dPiock",
            "aBpadl59AJs",
            "5jMhekOP4DE",
            "6CFmQSQlTz4",
            "ejg8KNSDGzA",
            "MsBxBj6fago",
            "11UhA-nsrdk",
            "GntSiIMHyVM",
            "SQdUONdqxJI",
            "xpJqm-Om3vY",
            "BpbgjLqv2XY",
            "75Pnzxxdnis",
            "Ry5kcEEKNN4",
            "F1apnSt5iuw",
            "d0peGya6R5Y",
            "A_cNlkZc5mw",
            "RTZ_u7LiEfg",
            "KlXveYRf9g8",
            "1qMqIpirwFg",
            "bYxVLLifeIc",
        ]);

        $this->setWomenIds([
            "_H6wpor9mjs",
            "mscml4ht7Qw",
            "PdcNOb4iYFs",
            "6uBLTrAJzxc",
            "L3bSgneg7cg",
            "1cn-6hJTMIs",
            "SEnRHxmvsv8",
            "g9dpfgrSyR8",
            "KJE--xk4AWE",
            "2DdCDqJCS3c",
            "AzVexpHvuKY",
            "A6O7pgc7vHg",
            "It0_SCr3AF4",
            "ZOo96227ahk",
            "8ACtYtJ5G-E",
            "4ewLF-Ixk5s",
            "Ya85swr-Hhs",
            "o0HLA4defew",
            "4gU0AY5YIDA",
            "0fN7Fxv1eWA",
            "2crxTr4jCkc",
            "3ujVzg9i2EI",
            "IF9TK5Uy-KI",
            "ayvBHeYBjpQ",
            "9YzXvVGsm-c",
            "J1OScm_uHUQ",
            "SjlvqlnSEhg",
            "3402kvtHhOo",
            "D0LVuxrS9Yg",
            "0BRT-fIiRyA",
            "zYXHEwrlbhw",
            "7ktP9yZA1g4",
            "oVi586BZ2lY",
            "j5almO1E8rU",
            "vhbfdV-YhmQ",
            "GYbBstR60Bw",
            "rlqDj-NS444",
            "i6v95kBybhM",
            "84Up7p6MupQ",
            "seBIOE8VvZs",
            "RrdULUfU-O4",
            "3ok_-Wvny2Q",
            "5rQG1mib90I",
        ]);
    }

    public function generateRandom(Gender $gender): string
    {
        $imageId = $this->randomIdFromGenderCollection($gender);
        return "https://source.unsplash.com/{$imageId}/600";
    }
}
