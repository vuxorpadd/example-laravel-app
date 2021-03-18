<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Inertia\Inertia;

class AuthorController extends Controller
{
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
}
