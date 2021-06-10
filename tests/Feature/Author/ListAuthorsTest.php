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
            fn(Assert $page) => $page
                ->component("Author/Index")
                ->has("paginator")
        );
    }

    /**
     * @test
     */
    public function authors_are_sorted_by_creation_date()
    {
        Author::factory()->createMany([
            ["id" => 1, "created_at" => Carbon::create("2020-01-03 00:59")],
            ["id" => 2, "created_at" => Carbon::create("2020-01-01 01:00")],
            ["id" => 3, "created_at" => Carbon::create("2020-01-04 01:00")],
            ["id" => 4, "created_at" => Carbon::create("2020-01-02 01:00")],
            ["id" => 5, "created_at" => Carbon::create("2020-01-03 01:00")],
        ]);
        $response = $this->get("/authors");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("paginator.data", function (
                $authors
            ) {
                $this->assertEquals(
                    [3, 5, 1, 4, 2],
                    $authors->pluck("id")->toArray()
                );

                return true;
            })
        );
    }

    /**
     * @test
     */
    public function pagination_works()
    {
        config()->set("app.settings.authors.items_per_page", 2);

        Author::factory()->createMany([
            ["id" => 1, "created_at" => Carbon::create("2020-01-03 01:00")],
            ["id" => 2, "created_at" => Carbon::create("2020-01-01 01:00")],
            ["id" => 3, "created_at" => Carbon::create("2020-01-04 01:00")],
            ["id" => 4, "created_at" => Carbon::create("2020-01-02 01:00")],
        ]);

        $response = $this->get("/authors");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("paginator.data", function (
                $authors
            ) {
                $this->assertEquals([3, 1], $authors->pluck("id")->toArray());

                return true;
            })
        );

        $response = $this->get("/authors?page=2");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("paginator.data", function (
                $authors
            ) {
                $this->assertEquals([4, 2], $authors->pluck("id")->toArray());

                return true;
            })
        );
    }

    /**
     * @test
     */
    public function out_of_bounds_page_shows_404()
    {
        config()->set("app.settings.authors.items_per_page", 2);

        Author::factory(2)->create();
        $this->assertDatabaseCount("authors", 2);

        $response = $this->get("/authors?page=2");

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function first_page_doesnt_show_404_if_there_are_no_authors_in_database()
    {
        config()->set("app.settings.authors.items_per_page", 2);

        $this->assertDatabaseCount("authors", 0);

        $response = $this->get("/authors");

        $response->assertStatus(200);
    }
}
