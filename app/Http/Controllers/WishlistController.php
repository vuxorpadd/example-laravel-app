<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function addremove(Book $book)
    {
        $wishlist = auth()->user()->wishlist;

        if ($wishlist->books->contains($book)) {
            $wishlist->books()->detach($book);
        } else {
            $wishlist->books()->attach($book);
        }

        return back();
    }

    public function clear()
    {
        auth()
            ->user()
            ->wishlist->books()
            ->delete();

        return back();
    }

    public function show()
    {
        return Inertia::render("Wishlist/Show");
    }
}
