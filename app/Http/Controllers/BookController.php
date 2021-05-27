<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;
use Inertia\Inertia;

class BookController extends Controller
{
    private string $bookCoverPath = "book-covers/";

    private function resizeCover(
        UploadedFile $cover
    ): \Psr\Http\Message\StreamInterface {
        $imageManager = Image::make($cover->path());
        $imageManager = $imageManager->fit(200, 300);
        return $imageManager->stream();
    }

    private function validationRules(array $overrides = []): array
    {
        return array_merge(
            [
                "title" => "required|string|max:100",
                "author_id" => "required|exists:authors,id",
                "subtitle" => "max:200",
                "description" => "max:2500",
                "preview" => "max:2500",
                "cover" => "required|image",
            ],
            $overrides
        );
    }

    public function index(): \Inertia\Response
    {
        $books = Book::all();
        return Inertia::render("Book/Index", ["books" => $books]);
    }

    public function show(Book $book): \Inertia\Response
    {
        return Inertia::render("Book/Show", ["book" => $book]);
    }

    public function create()
    {
        $authors = Author::orderBy("name")->get();
        return Inertia::render("Book/Create", compact("authors"));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $cover = $request->file("cover");
        $path = $this->bookCoverPath . $cover->hashName();

        Storage::put($path, $this->resizeCover($cover));

        Book::create(["cover" => $path] + $request->all());

        return redirect(route("books.index"));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy("name")->get();
        return Inertia::render("Book/Edit", compact("book", "authors"));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Book $book)
    {
        $this->validate($request, $this->validationRules());

        $newCover = $request->file("cover");
        $newCoverPath = $this->bookCoverPath . $newCover->hashName();

        Storage::put($newCoverPath, $this->resizeCover($newCover));

        $oldCoverPath = $book->cover;

        $book->update(["cover" => $newCoverPath] + $request->all());
        Storage::delete($oldCoverPath);

        return redirect(route("books.show", compact("book")));
    }
}
