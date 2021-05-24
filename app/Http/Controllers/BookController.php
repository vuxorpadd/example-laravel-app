<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Inertia\Inertia;

class BookController extends Controller
{
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
        return Inertia::render("Book/Create");
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required|string|max:100",
            "author_id" => "required|exists:authors,id",
            "subtitle" => "max:200",
            "description" => "max:2500",
            "preview" => "max:2500",
            "cover" => "required|image",
        ]);

        $cover = $request->file("cover");

        $imageManager = Image::make($cover->path());
        $imageManager = $imageManager->fit(200, 300);
        $coverContent = $imageManager->stream();

        $path = "book-covers/" . $cover->hashName();

        Storage::put($path, $coverContent);

        Book::create(["cover" => $path] + $request->all());

        return redirect(route("books.index"));
    }
}
