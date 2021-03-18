<?php

namespace Tests\Feature\Book;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class AuthorListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function opening_author_list_page()
    {
        $response = $this->get("/authors");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->component("Author/Index")->has("authors")
        );
    }
}
