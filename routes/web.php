<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
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
Route::get("/books", [BookController::class, "index"])->name("books.index");

Route::group(["middleware" => ["auth", "checkRole:admin"]], function () {
    Route::get("/books/create", [BookController::class, "create"])->name(
        "books.create"
    );
    Route::post("/books", [BookController::class, "store"])->name(
        "books.store"
    );
    Route::get("/books/{book}/edit", [BookController::class, "edit"])->name(
        "books.edit"
    );
    Route::put("/books/{book}", [BookController::class, "update"])->name(
        "books.update"
    );
});

Route::get("/books/{book}", [BookController::class, "show"])->name(
    "books.show"
);

Route::get("/authors", [AuthorController::class, "index"])->name(
    "authors.index"
);
Route::get("/authors/{author}", [AuthorController::class, "show"])->name(
    "authors.show"
);
