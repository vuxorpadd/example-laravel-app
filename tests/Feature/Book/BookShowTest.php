<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class BookShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function opening_book_list_page()
    {
        $book = Book::factory()->create([
            "id" => 1,
            "title" => "BOOK A",
        ]);

        $response = $this->get("/books/1");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Book/Show")
                ->has("book")
                ->where("book.title", "BOOK A")
        );
    }
}
