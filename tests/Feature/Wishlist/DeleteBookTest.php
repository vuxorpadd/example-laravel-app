<?php

namespace Tests\Feature\Wishlist;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function the_book_is_removed_from_the_wishlist_when_it_is_deleted()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);
        $anotherWishlist = Wishlist::factory()->create([
            "user_id" => $user->id,
        ]);

        $book = Book::factory()->create();

        $wishlist->books()->attach($book);
        $anotherWishlist->books()->attach($book);

        $this->assertCount(1, $wishlist->books);
        $this->assertCount(1, $anotherWishlist->books);

        $response = $this->actingAs($user)->delete("/books/{$book->id}");

        $this->assertDatabaseCount("books", 0);

        $this->assertCount(0, $wishlist->fresh()->books);
        $this->assertCount(0, $anotherWishlist->fresh()->books);
    }
}
