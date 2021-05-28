<?php

namespace Tests\Feature\Author;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\Assert;
use Tests\TestCase;

class EditAuthorTest extends TestCase
{
    use RefreshDatabase;

    private File $newPhoto;
    private File $oldPhoto;

    protected function setUp(): void
    {
        parent::setUp();

        \Storage::fake();

        $this->oldPhoto = UploadedFile::fake()->image("photo-old.jpg");
        $this->newPhoto = UploadedFile::fake()->image("photo-new.jpg");
    }

    private function authorPhotosPath(): string
    {
        return "author-photos/";
    }

    private function oldPhotoFilepath(): string
    {
        return $this->authorPhotosPath() . $this->oldPhoto->hashName();
    }

    private function newPhotoFilepath(): string
    {
        return $this->authorPhotosPath() . $this->newPhoto->hashName();
    }

    private function oldAttributes($overrides = []): array
    {
        return array_merge(
            [
                "name" => "OLD NAME",
                "bio" => "OLD BIO",
                "birthdate" => "2010-01-01",
                "photo" => $this->oldPhotoFilepath(),
            ],
            $overrides
        );
    }

    private function validFields($overrides = []): array
    {
        return array_merge(
            [
                "name" => "NEW NAME",
                "bio" => "NEW BIO",
                "birthdate" => "2020-01-01",
                "photo" => $this->newPhoto,
            ],
            $overrides
        );
    }

    private function saveOldPhotoOnStorage(): string
    {
        $oldImagePath = $this->oldPhotoFilepath();

        \Storage::put($oldImagePath, $this->oldPhoto->getContent());

        return $oldImagePath;
    }

    /**
     * @test
     */
    public function guests_have_no_access_to_edit_author_form()
    {
        $author = Author::factory()->create();

        $response = $this->get("/authors/{$author->id}/edit");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_have_no_access_to_edit_author_form()
    {
        $user = User::factory()
            ->user()
            ->create();

        $author = Author::factory()->create();

        $response = $this->actingAs($user)->get("/authors/{$author->id}/edit");

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admins_have_access_to_edit_author_form()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create();

        $response = $this->actingAs($user)->get("/authors/{$author->id}/edit");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Author/Edit")
                ->has("author")
                ->where("author.id", $author->id)
        );
    }

    /**
     * @test
     */
    public function guests_cannot_edit_an_author()
    {
        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->put("/authors/{$author->id}", $this->validFields());

        $response->assertStatus(302);
        $response->assertRedirect("/login");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function users_cannot_edit_an_author()
    {
        $user = User::factory()
            ->user()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)->put(
            "/authors/{$author->id}",
            $this->validFields()
        );

        $response->assertStatus(403);

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function admins_can_edit_an_author()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)->put(
            "/authors/{$author->id}",
            $this->validFields()
        );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}");

        \Storage::assertExists($this->newPhotoFilepath());

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->validFields(["photo" => $this->newPhotoFilepath()]),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function name_is_required()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "name" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("name");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function name_is_50_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "name" => str_repeat("A", 51),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("name");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function birthdate_is_required()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "birthdate" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("birthdate");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function birthdate_is_a_date()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "birthdate" => "NOT A DATE",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("birthdate");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function birthdate_is_in_the_past()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "birthdate" => "2099-01-01",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("birthdate");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function bio_is_optional()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "bio" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}");

        $response->assertSessionDoesntHaveErrors("bio");
    }

    /**
     * @test
     */
    public function bio_is_10000_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "bio" => str_repeat("A", 10001),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("bio");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function photo_is_optional()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "photo" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}");

        $response->assertSessionDoesntHaveErrors("photo");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->validFields([
                "photo" => $this->oldAttributes()["photo"],
            ]),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function photo_is_an_image()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/authors/{$author->id}/edit")
            ->put(
                "/authors/{$author->id}",
                $this->validFields([
                    "photo" => "NOT AN IMAGE",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/{$author->id}/edit");

        $response->assertSessionHasErrors("photo");

        $freshAuthor = $author->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshAuthor->getAttributes()
        );
    }

    /**
     * @test
     */
    public function photo_is_resized()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $photoFile = UploadedFile::fake()->image("photo.jpg", 2560, 1440);
        $fullFileSize = filesize($photoFile);

        $this->actingAs($user)->put(
            "/authors/{$author->id}",
            $this->validFields([
                "photo" => $photoFile,
            ])
        );

        $filepath = $this->authorPhotosPath() . $photoFile->hashName();

        \Storage::assertExists($filepath);

        $this->assertLessThan($fullFileSize, \Storage::size($filepath));

        list($width, $height) = getimagesizefromstring(
            \Storage::get($filepath)
        );

        $this->assertEquals(300, $width);
        $this->assertEquals(300, $height);
    }

    /**
     * @test
     */
    public function unsuccessful_file_upload()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $photo = UploadedFile::fake()->createWithContent("photo.jpg", null);

        $response = $this->actingAs($user)->put(
            "/authors/{$author->id}",
            $this->validFields([
                "photo" => $photo,
            ])
        );

        $response->assertStatus(500);
    }

    /**
     * @test
     */
    public function old_photo_is_deleted()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $author = Author::factory()->create($this->oldAttributes());

        $oldImagePath = $this->saveOldPhotoOnStorage();
        \Storage::assertExists($oldImagePath);

        $this->actingAs($user)->put(
            "/authors/{$author->id}",
            $this->validFields()
        );

        \Storage::assertMissing($oldImagePath);
    }
}
