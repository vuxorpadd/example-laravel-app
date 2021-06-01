<?php

namespace Tests\Feature\Wishlist;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateWishlistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function wishlist_is_autocreated_if_it_doesnt_exist()
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount("wishlists", 0);

        $wishlist = $user->wishlist;

        $this->assertDatabaseCount("wishlists", 1);
    }
}
