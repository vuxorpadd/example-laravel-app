<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
}
