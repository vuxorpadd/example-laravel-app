<?php

namespace Tests\Feature\Author;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ListAuthorsTest extends TestCase
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

    /**
     * @test
     */
    public function authors_are_sorted_by_creation_date()
    {
        Author::factory()->createMany([
            ["id" => 1, "created_at" => Carbon::create("2020-01-03")],
            ["id" => 2, "created_at" => Carbon::create("2020-01-01")],
            ["id" => 3, "created_at" => Carbon::create("2020-01-04")],
            ["id" => 4, "created_at" => Carbon::create("2020-01-02")],
        ]);
        $response = $this->get("/authors");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("authors", function ($authors) {
                $this->assertEquals(
                    [3, 1, 4, 2],
                    $authors->pluck("id")->toArray()
                );

                return true;
            })
        );
    }
}
