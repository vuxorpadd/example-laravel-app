<?php

namespace Tests\Feature\Wishlist;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClearWishlistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_clear_wishlists()
    {
        $wishlist = Wishlist::factory()->create();
        $book = Book::factory()->create();
        $wishlist->books()->attach($book);

        $this->assertCount(1, $wishlist->books);

        $response = $this->put("/wishlist/clear");

        $response->assertStatus(302);
        $response->assertRedirect("/login");

        $this->assertCount(1, $wishlist->fresh()->books);
    }

    /**
     * @test
     */
    public function users_can_clear_wishlist()
    {
        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);
        $books = Book::factory(2)->create();
        $wishlist->books()->attach($books);

        $this->assertCount(2, $wishlist->books);

        $response = $this->actingAs($user)->put("/wishlist/clear");

        $response->assertStatus(200);

        $freshWishlist = $wishlist->fresh();

        $this->assertCount(0, $freshWishlist->books);
    }
}
