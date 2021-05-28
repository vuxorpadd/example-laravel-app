<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Image;
use Inertia\Inertia;

class AuthorController extends Controller
{
    private function resizeImage(
        UploadedFile $image
    ): \Psr\Http\Message\StreamInterface {
        $imageManager = Image::make($image->path());
        $imageManager = $imageManager->fit(300, 300);
        return $imageManager->stream();
    }

    public function index()
    {
        $authors = Author::all();
        return Inertia::render("Author/Index", ["authors" => $authors]);
    }

    public function show(Author $author)
    {
        return Inertia::render("Author/Show", [
            "author" => $author->load("books"),
        ]);
    }

    public function create()
    {
        return Inertia::render("Author/Create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required|max:50",
            "birthdate" => "required|date|before:now",
            "bio" => "max:10000",
            "photo" => "required|image",
        ]);

        $photo = $request->file("photo");
        $photoPath = "author-photos/" . $photo->hashName();

        \Storage::put($photoPath, $this->resizeImage($photo));

        Author::create(["photo" => $photoPath] + $request->all());
        return redirect(route("authors.index"));
    }
}
