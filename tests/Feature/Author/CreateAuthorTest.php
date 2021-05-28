<?php

namespace Tests\Feature\Author;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\Assert;
use Tests\TestCase;

class CreateAuthorTest extends TestCase
{
    use RefreshDatabase;

    private string $authorPhotosPath = "author-photos/";
    private File $photoFile;

    protected function setUp(): void
    {
        parent::setUp();
        \Storage::fake();
        $this->photoFile = UploadedFile::fake()->image("photo.jpg");
    }

    private function validFields($overrides = []): array
    {
        return array_merge(
            [
                "name" => "SEMEN DNIPRO",
                "birthdate" => "1991-08-24",
                "bio" => "ABOUT AUTHOR",
                "photo" => $this->photoFile,
            ],
            $overrides
        );
    }

    /**
     * @test
     */
    public function guests_have_no_access_to_add_author_form()
    {
        $response = $this->get("/authors/create");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_have_no_access_to_add_author_form()
    {
        $user = User::factory()
            ->user()
            ->create();

        $response = $this->actingAs($user)->get("/authors/create");

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admins_have_access_to_add_author_form()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $response = $this->actingAs($user)->get("/authors/create");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->component("Author/Create")
        );
    }

    /**
     * @test
     */
    public function guests_cannot_create_an_author()
    {
        $this->assertDatabaseCount("authors", 0);

        $response = $this->post("/authors", $this->validFields());

        $response->assertStatus(302);
        $response->assertRedirect("/login");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function users_cannot_create_an_author()
    {
        $user = User::factory()
            ->user()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)->post(
            "/authors",
            $this->validFields()
        );

        $response->assertStatus(403);

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function admins_can_create_an_author()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post("/authors", $this->validFields());

        $response->assertStatus(302);
        $response->assertRedirect("/authors");

        $this->assertDatabaseCount("authors", 1);

        $filepath =
            $this->authorPhotosPath . $this->validFields()["photo"]->hashName();

        \Storage::assertExists($filepath);

        $author = Author::first();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->validFields(["photo" => $filepath]),
            $author->getAttributes()
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

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "name" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("name");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function name_is_50_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "name" => str_repeat("A", 51),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("name");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function birthdate_is_required()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "birthdate" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("birthdate");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function birthdate_is_a_date()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "birthdate" => "NOT A DATE",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("birthdate");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function birthdate_is_in_the_past()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "birthdate" => "2099-01-01",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("birthdate");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function bio_is_optional()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "bio" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors");

        $response->assertSessionDoesntHaveErrors("bio");

        $this->assertDatabaseCount("authors", 1);
    }

    /**
     * @test
     */
    public function bio_is_10000_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "bio" => str_repeat("A", 10001),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("bio");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function photo_is_required()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "photo" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("photo");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function photo_is_an_image()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertDatabaseCount("authors", 0);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post(
                "/authors",
                $this->validFields([
                    "photo" => "NOT AN IMAGE",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/authors/create");

        $response->assertSessionHasErrors("photo");

        $this->assertDatabaseCount("authors", 0);
    }

    /**
     * @test
     */
    public function photo_is_resized()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $uploadedPhoto = UploadedFile::fake()->image("photo.jpg", 2560, 1440);

        $fullFileSize = filesize($uploadedPhoto);

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post("/authors", $this->validFields(["photo" => $uploadedPhoto]));

        $response->assertStatus(302);
        $response->assertRedirect("/authors");

        $filepath = $this->authorPhotosPath . $uploadedPhoto->hashName();
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

        $uploadedPhoto = UploadedFile::fake()->createWithContent(
            "photo.jpg",
            null
        );

        $response = $this->actingAs($user)
            ->from("/authors/create")
            ->post("/authors", $this->validFields(["photo" => $uploadedPhoto]));

        $response->assertStatus(500);
    }
}
