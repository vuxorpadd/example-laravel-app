<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", fn() => redirect("/books"));

Route::middleware(["auth:sanctum", "verified"])
    ->get("/dashboard", function () {
        return Inertia::render("Dashboard");
    })
    ->name("dashboard");

//Custom
Route::resource("books", BookController::class);
Route::resource("authors", AuthorController::class);

Route::put("/wishlist/addremove/{book}", [
    WishlistController::class,
    "addremove",
])->name("wishlist.addremove");
Route::put("/wishlist/clear", [WishlistController::class, "clear"])->name(
    "wishlist.clear"
);
