<?php

namespace Tests\Feature\Wishlist;

use App\Mail\WishlistEmail;
use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendToEmailTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guests_cannot_send_wishlist_to_email()
    {
        Wishlist::factory()->create();

        $response = $this->post("/wishlist/send-to-email");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_can_send_wishlist_to_email()
    {
        \Mail::fake();

        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);
        $book = Book::factory()->create([
            "title" => "BOOK TITLE",
            "subtitle" => "BOOK SUBTITLE",
        ]);
        $wishlist->books()->attach($book);

        $response = $this->actingAs($user)->post("/wishlist/send-to-email");

        $response->assertStatus(302);
        $response->assertRedirect("/wishlist");

        \Mail::assertSent(function (WishlistEmail $email) use (
            $user,
            $wishlist
        ) {
            return $email->hasTo($user->email) &&
                $email->wishlist->id === $wishlist->id;
        });
    }

    /**
     * @test
     */
    public function users_cannot_send_wishlist_to_email_if_wishlist_is_empty()
    {
        \Mail::fake();

        $user = User::factory()->create();
        $wishlist = Wishlist::factory()->create(["user_id" => $user->id]);

        $this->assertCount(0, $wishlist->books);

        $response = $this->actingAs($user)->post("/wishlist/send-to-email");

        $response->assertStatus(302);
        $response->assertRedirect("/wishlist");

        $response->assertSessionHasErrors("wishlist");

        \Mail::assertNotSent(WishlistEmail::class);
    }
}
