<?php

namespace App\Http\Controllers;

use App\Mail\WishlistEmail;
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
            ->detach();

        return back();
    }

    public function show()
    {
        return Inertia::render("Wishlist/Show");
    }

    public function sendToEmail()
    {
        $user = auth()->user();

        if ($user->wishlist->isEmpty()) {
            return redirect(route("wishlist.show"))->withErrors([
                "wishlist" => "Wishlist is empty",
            ]);
        }

        \Mail::to($user)->send(new WishlistEmail($user->wishlist));

        return redirect(route("wishlist.show"));
    }
}
