<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Image;

class ImageService
{
    public function resizeImage(
        UploadedFile $image,
        int $width,
        int $height
    ): \Psr\Http\Message\StreamInterface {
        $imageManager = Image::make($image->path());
        $imageManager = $imageManager->fit($width, $height);
        $imageManager->stream();

        return $imageManager->stream();
    }
}
