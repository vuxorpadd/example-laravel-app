<?php

namespace App\Http\Controllers;

use App\ImageService;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AuthorController extends Controller
{
    private string $authorPhotosPath = "author-photos/";
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->middleware("auth", ["except" => ["index", "show"]]);
        $this->authorizeResource(Author::class, "author");
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
        $photoPath = $this->authorPhotosPath . $photo->hashName();

        \Storage::put($photoPath, $this->resizePhoto($photo));

        Author::create(["photo" => $photoPath] + $request->all());
        return redirect(route("authors.index"));
    }

    public function edit(Author $author)
    {
        return Inertia::render("Author/Edit", compact("author"));
    }

    public function update(Request $request, Author $author)
    {
        $this->validate($request, [
            "name" => "required|max:50",
            "birthdate" => "required|date|before:now",
            "bio" => "max:10000",
            "photo" => "nullable|image",
        ]);

        $newPhoto = $request->file("photo");

        if ($newPhoto) {
            $oldPhotoPath = $author->photo;

            $newPhotoPath = $this->authorPhotosPath . $newPhoto->hashName();
            Storage::put($newPhotoPath, $this->resizePhoto($newPhoto));

            $author->photo = $newPhotoPath;
        }

        $author->update($request->except("photo"));

        if ($newPhoto && Storage::exists($author->photo)) {
            Storage::delete($oldPhotoPath);
        }

        return redirect(route("authors.show", compact("author")));
    }

    public function destroy(Author $author)
    {
        $author->delete();

        if (Storage::exists($author->photo)) {
            Storage::delete($author->photo);
        }

        return redirect(route("authors.index"));
    }
}
