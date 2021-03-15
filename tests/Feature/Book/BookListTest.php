<?php

namespace Tests\Feature\Book;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class BookListTest extends TestCase
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
}
