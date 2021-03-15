<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render("Book/Index");
    }
}
