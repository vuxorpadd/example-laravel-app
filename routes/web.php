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
Route::group(["middleware" => ["auth", "checkRole:admin"]], function () {
    Route::resource("books", BookController::class);
    Route::resource("authors", AuthorController::class);
});

Route::name("books.")->group(function () {
    Route::get("/books", [BookController::class, "index"])->name("index");
    Route::get("/books/{book}", [BookController::class, "show"])->name("show");
});

Route::name("authors.")->group(function () {
    Route::get("/authors", [AuthorController::class, "index"])->name("index");
    Route::get("/authors/{author}", [AuthorController::class, "show"])->name(
        "show"
    );
});
