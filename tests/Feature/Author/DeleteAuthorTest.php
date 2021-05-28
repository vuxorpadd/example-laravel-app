<?php

namespace Tests\Feature\Author;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteAuthorTest extends TestCase
{
    use RefreshDatabase;

    private string $authorPhotosPath = "author-photos/";

    /**
     * @test
     */
    public function guests_cannot_delete_an_author()
    {
        $author = Author::factory()->create();

        $this->assertDatabaseCount("authors", 1);

        $response = $this->delete("/authors/{$author->id}");

        $response->assertStatus(302);
        $response->assertRedirect("/login");

        $this->assertDatabaseCount("authors", 1);
    }

    /**
     * @test
     */
    public function users_cannot_delete_an_author()
    {
        $user = User::factory()
            ->user()
            ->create();

        $author = Author::factory()->create();

        $this->assertDatabaseCount("authors", 1);

        $response = $this->actingAs($user)->delete("/authors/{$author->id}");

        $response->assertStatus(403);

        $this->assertDatabaseCount("authors", 1);
    }

    /**
     * @test
     */
    public function admins_can_delete_an_author()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create();

        $this->assertDatabaseCount("authors", 1);

        $response = $this->actingAs($user)->delete("/authors/{$author->id}");

        $response->assertStatus(302);
        $response->assertRedirect("/authors");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function photo_file_is_deleted()
    {
        $user = User::factory()
            ->admin()
            ->create();

        \Storage::fake();

        $photoImage = UploadedFile::fake()->image("photo.jpg");
        $photoImagePath = $this->authorPhotosPath . $photoImage->hashName();

        \Storage::put($photoImagePath, $photoImage->getContent());
        \Storage::assertExists($photoImagePath);

        $author = Author::factory()->create(["photo" => $photoImagePath]);

        $this->actingAs($user)->delete("/authors/{$author->id}");

        \Storage::assertMissing($photoImagePath);
    }
}
