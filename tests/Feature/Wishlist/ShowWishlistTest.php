<?php

namespace Tests\Feature\Wishlist;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ShowWishlistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_access_wishlist_page()
    {
        $wishlist = Wishlist::factory()->create();
        $books = Book::factory(10)->create();

        $wishlist->books()->attach($books);

        $response = $this->get("/wishlist");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_can_access_wishlist_page()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);
        $books = Book::factory(10)->create();

        $wishlist->books()->attach($books);

        $response = $this->actingAs($user)->get("/wishlist");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Wishlist/Show")
                ->has("wishlist", 10)
        );
    }
}
