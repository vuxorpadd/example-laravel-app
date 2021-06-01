<?php

namespace Tests\Feature\Wishlist;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddRemoveBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_addremove_books()
    {
        Wishlist::factory()->create();
        $book = Book::factory()->create();

        $response = $this->put("/wishlist/addremove/{$book->id}");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_can_addremove_books()
    {
        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->put(
            "/wishlist/addremove/{$book->id}"
        );

        $response->assertStatus(200);

        $freshWishlist = $wishlist->fresh();

        $this->assertCount(1, $freshWishlist->books);
        $this->assertEquals($book->id, $freshWishlist->books->first()->id);
    }

    /**
     * @test
     */
    public function books_is_removed_if_it_is_already_in_wishlist()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);
        $book = Book::factory()->create();
        $wishlist->books()->attach($book);

        $this->assertCount(1, $wishlist->books);

        $response = $this->actingAs($user)->put(
            "/wishlist/addremove/{$book->id}"
        );

        $response->assertStatus(200);

        $freshWishlist = $wishlist->fresh();

        $this->assertCount(0, $freshWishlist->books);
    }
}
