<?php

namespace Tests\Feature\Book;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class AuthorShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function opening_book_list_page()
    {
        Author::factory()->create([
            "id" => "1",
            "name" => "JOHN GREEN",
            "birthdate" => Carbon::parse("1960-01-01"),
            "bio" => "JOHN GREEN WAS AN AUTHOR",
            "photo" => "http://author-photo.jpg",
        ]);

        Book::factory(2)->create([
            "author_id" => 1,
        ]);

        $response = $this->get("/authors/1");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Author/Show")
                ->has("author")
                ->where("author.name", "JOHN GREEN")
                ->where("author.birthdate", "1960-01-01")
                ->where("author.bio", "JOHN GREEN WAS AN AUTHOR")
                ->where("author.photo", "http://author-photo.jpg")
                ->has("author.books", 2)
        );
    }
}
