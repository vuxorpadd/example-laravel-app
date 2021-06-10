<?php

namespace Tests\Feature\Author;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ShowAuthorTest extends TestCase
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
                ->has("booksPaginator.data", 2)
        );
    }

    /**
     * @test
     */
    public function books_are_sorted_by_creation_date()
    {
        config()->set("app.settings.books.items_per_page", 5);

        $author = Author::factory()->create([
            "id" => 1,
            "name" => "JOHN GREEN",
            "birthdate" => Carbon::parse("1960-01-01"),
            "bio" => "JOHN GREEN WAS AN AUTHOR",
            "photo" => "http://author-photo.jpg",
        ]);

        $books = Book::factory()->createMany([
            ["id" => 1, "created_at" => Carbon::create("2020-01-03 00:59")],
            ["id" => 2, "created_at" => Carbon::create("2020-01-01 01:00")],
            ["id" => 3, "created_at" => Carbon::create("2020-01-04 01:00")],
            ["id" => 4, "created_at" => Carbon::create("2020-01-02 01:00")],
            ["id" => 5, "created_at" => Carbon::create("2020-01-03 01:00")],
        ]);

        $author->books()->saveMany($books);

        $response = $this->get("/authors/1");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("booksPaginator.data", function (
                $books
            ) {
                $this->assertEquals(
                    [3, 5, 1, 4, 2],
                    $books->pluck("id")->toArray()
                );

                return true;
            })
        );
    }

    /**
     * @test
     */
    public function books_pagination_works()
    {
        config()->set("app.settings.books.items_per_page", 2);

        $author = Author::factory()->create([
            "id" => 1,
            "name" => "JOHN GREEN",
            "birthdate" => Carbon::parse("1960-01-01"),
            "bio" => "JOHN GREEN WAS AN AUTHOR",
            "photo" => "http://author-photo.jpg",
        ]);

        $books = Book::factory()->createMany([
            ["id" => 1, "created_at" => Carbon::create("2020-01-03 01:00")],
            ["id" => 2, "created_at" => Carbon::create("2020-01-01 01:00")],
            ["id" => 3, "created_at" => Carbon::create("2020-01-04 01:00")],
            ["id" => 4, "created_at" => Carbon::create("2020-01-02 01:00")],
        ]);

        $author->books()->saveMany($books);

        $response = $this->get("/authors/1");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("booksPaginator.data", function (
                $books
            ) {
                $this->assertEquals([3, 1], $books->pluck("id")->toArray());

                return true;
            })
        );

        $response = $this->get("/authors/1?page=2");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("booksPaginator.data", function (
                $books
            ) {
                $this->assertEquals([4, 2], $books->pluck("id")->toArray());

                return true;
            })
        );
    }
}
