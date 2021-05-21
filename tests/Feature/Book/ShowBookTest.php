<?php

namespace Tests\Feature\Book;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ShowBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function opening_book_show_page()
    {
        Author::factory()->create([
            "id" => "1",
            "name" => "JOHN GREEN",
        ]);

        Book::factory()->create([
            "id" => 1,
            "title" => "BOOK A",
            "subtitle" => "STORY A",
            "description" => "BOOK ABOUT A",
            "preview" => "ONCE UPON A TIME",
            "cover" => "http://cover-image.png",
            "author_id" => 1,
        ]);

        $response = $this->get("/books/1");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Book/Show")
                ->has("book")
                ->where("book.title", "BOOK A")
                ->where("book.subtitle", "STORY A")
                ->where("book.description", "BOOK ABOUT A")
                ->where("book.preview", "ONCE UPON A TIME")
                ->where("book.cover", "http://cover-image.png")
                ->where("book.author.name", "JOHN GREEN")
        );
    }
}
