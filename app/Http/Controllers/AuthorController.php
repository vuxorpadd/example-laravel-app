<?php

namespace App\Http\Controllers;

use App\ImageService;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;

class AuthorController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    private function resizePhoto(
        UploadedFile $cover
    ): \Psr\Http\Message\StreamInterface {
        return $this->imageService->resizeImage($cover, 300, 300);
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

        \Storage::put($photoPath, $this->resizePhoto($photo));

        Author::create(["photo" => $photoPath] + $request->all());
        return redirect(route("authors.index"));
    }
}
