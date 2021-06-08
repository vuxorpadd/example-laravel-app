<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ListBooksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function opening_book_list_page()
    {
        $response = $this->get("/books");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->component("Book/Index")->has("books")
        );
    }

    /**
     * @test
     */
    public function books_are_sorted_by_creation_date()
    {
        Book::factory()->createMany([
            ["id" => 1, "created_at" => Carbon::create("2020-01-03")],
            ["id" => 2, "created_at" => Carbon::create("2020-01-01")],
            ["id" => 3, "created_at" => Carbon::create("2020-01-04")],
            ["id" => 4, "created_at" => Carbon::create("2020-01-02")],
        ]);
        $response = $this->get("/books");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("books", function ($books) {
                $this->assertEquals(
                    [3, 1, 4, 2],
                    $books->pluck("id")->toArray()
                );

                return true;
            })
        );
    }
}
