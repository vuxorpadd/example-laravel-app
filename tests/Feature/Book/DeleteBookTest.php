<?php

namespace Tests\Feature\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteBookTest extends TestCase
{
    use RefreshDatabase;

    private string $bookCoversPath = "book-covers/";

    /**
     * @test
     */
    public function guests_cannot_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->delete("/books/{$book->id}");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_cannot_delete_a_book()
    {
        $user = User::factory()
            ->user()
            ->create();

        $book = Book::factory()->create();

        $response = $this->actingAs($user)->delete("/books/{$book->id}");

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admins_can_delete_a_book()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create();

        $this->assertDatabaseCount("books", 1);

        $response = $this->actingAs($user)->delete("/books/{$book->id}");

        $response->assertStatus(302);
        $response->assertRedirect("/books");

        $this->assertDatabaseCount("books", 0);
    }

    /**
     * @test
     */
    public function cover_file_is_deleted()
    {
        $user = User::factory()
            ->admin()
            ->create();

        \Storage::fake();

        $coverImage = UploadedFile::fake()->image("cover.jpg");
        $coverImagePath = $this->bookCoversPath . $coverImage->hashName();

        \Storage::put($coverImagePath, $coverImage->getContent());
        \Storage::assertExists($coverImagePath);

        $book = Book::factory()->create(["cover" => $coverImagePath]);

        $this->actingAs($user)->delete("/books/{$book->id}");

        \Storage::assertMissing($coverImagePath);
    }
}
