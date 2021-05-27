<?php

namespace Tests\Feature\Book;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\Assert;
use Tests\TestCase;

class EditBookTest extends TestCase
{
    use RefreshDatabase;

    private File $coverNew;
    private File $coverOld;

    protected function setUp(): void
    {
        parent::setUp();

        \Storage::fake();

        $this->coverOld = UploadedFile::fake()->image("cover-old.jpg");
        $this->coverNew = UploadedFile::fake()->image("cover-new.jpg");
    }

    private function bookCoversPath(): string
    {
        return "book-covers/";
    }

    private function coverOldFilepath(): string
    {
        return $this->bookCoversPath() . $this->coverOld->hashName();
    }

    private function coverNewFilepath(): string
    {
        return $this->bookCoversPath() . $this->coverNew->hashName();
    }

    private function oldAttributes($overrides = []): array
    {
        return array_merge(
            [
                "title" => "OLD BOOK",
                "author_id" => "1",
                "subtitle" => "OLD SUBTITLE",
                "description" => "OLD DESCRIPTION",
                "preview" => "OLD PREVIEW",
                "cover" => $this->coverOldFilepath(),
            ],
            $overrides
        );
    }

    private function validFields($overrides = []): array
    {
        return array_merge(
            [
                "title" => "NEW BOOK TITLE",
                "author_id" => "2",
                "subtitle" => "NEW SUBTITLE",
                "description" => "NEW DESCRIPTION",
                "preview" => "NEW PREVIEW",
                "cover" => $this->coverNew,
            ],
            $overrides
        );
    }

    private function createOldCoverOnStorage(): string
    {
        $oldImagePath = $this->coverOldFilepath();

        \Storage::put($oldImagePath, $this->coverOld->getContent());

        return $oldImagePath;
    }

    /**
     * @test
     */
    public function guests_have_no_access_to_edit_book_form()
    {
        $book = Book::factory()->create();

        $response = $this->get("/books/{$book->id}/edit");

        $response->assertStatus(302);
        $response->assertRedirect("/login");
    }

    /**
     * @test
     */
    public function users_have_no_access_to_edit_book_form()
    {
        $user = User::factory()
            ->user()
            ->create();

        $book = Book::factory()->create();

        $response = $this->actingAs($user)->get("/books/{$book->id}/edit");

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admins_have_access_to_edit_book_form()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(3)->create();

        $book = Book::factory()->create();

        $response = $this->actingAs($user)->get("/books/{$book->id}/edit");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page
                ->component("Book/Edit")
                ->has("book")
                ->where("book.id", $book->id)
                ->has("authors", 3)
        );
    }

    /**
     * @test
     */
    public function authors_are_sorted_alphabetically()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory()->createMany([
            ["id" => 1, "name" => "Semen"],
            ["id" => 2, "name" => "Melanka"],
            ["id" => 3, "name" => "Petro"],
            ["id" => 4, "name" => "Olenka"],
        ]);

        $book = Book::factory()->create();

        $response = $this->actingAs($user)->get("/books/{$book->id}/edit");

        $response->assertStatus(200);

        $response->assertInertia(
            fn(Assert $page) => $page->where("authors", function ($authors) {
                $this->assertEquals("2,4,3,1", $authors->implode("id", ","));
                return true;
            })
        );
    }

    /**
     * @test
     */
    public function guests_cannot_edit_a_book()
    {
        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->put("/books/{$book->id}", $this->validFields());

        $response->assertStatus(302);
        $response->assertRedirect("/login");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function users_cannot_edit_a_book()
    {
        $user = User::factory()
            ->user()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)->put(
            "/books/{$book->id}",
            $this->validFields()
        );

        $response->assertStatus(403);

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function admins_can_edit_a_book()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)->put(
            "/books/{$book->id}",
            $this->validFields()
        );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}");

        $filepath = $this->coverNewFilepath();
        \Storage::assertExists($filepath);

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->validFields(["cover" => $filepath]),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function title_is_required()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put("/books/{$book->id}", $this->validFields(["title" => null]));

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("title");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function title_is_100_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "title" => str_repeat("A", 101),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("title");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function author_is_required()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "author_id" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("author_id");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function author_exists()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());
        $this->assertDatabaseMissing("authors", ["id" => 2]);

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "author_id" => 2,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("author_id");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function subtitle_is_optional()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "subtitle" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}");

        $response->assertSessionDoesntHaveErrors("subtitle");
    }

    /**
     * @test
     */
    public function subtitle_is_200_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "subtitle" => str_repeat("A", 201),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("subtitle");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function description_is_optional()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "description" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}");

        $response->assertSessionDoesntHaveErrors("description");
    }

    /**
     * @test
     */
    public function description_is_2500_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "description" => str_repeat("A", 2501),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("description");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function preview_is_optional()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "preview" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}");

        $response->assertSessionDoesntHaveErrors("preview");
    }

    /**
     * @test
     */
    public function preview_is_2500_chars_max()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "preview" => str_repeat("A", 2501),
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("preview");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function cover_is_optional()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "cover" => null,
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}");

        $response->assertSessionDoesntHaveErrors("cover");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->validFields([
                "cover" => $this->oldAttributes()["cover"],
            ]),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function cover_is_an_image()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $book = Book::factory()->create($this->oldAttributes());

        $response = $this->actingAs($user)
            ->from("/books/{$book->id}/edit")
            ->put(
                "/books/{$book->id}",
                $this->validFields([
                    "cover" => "NOT AN IMAGE",
                ])
            );

        $response->assertStatus(302);
        $response->assertRedirect("/books/{$book->id}/edit");

        $response->assertSessionHasErrors("cover");

        $freshBook = $book->fresh();

        \Illuminate\Testing\Assert::assertArraySubset(
            $this->oldAttributes(),
            $freshBook->getAttributes()
        );
    }

    /**
     * @test
     */
    public function cover_is_resized()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $coverFile = UploadedFile::fake()->image("cover.jpg", 2560, 1440);
        $fullFileSize = filesize($coverFile);

        $this->actingAs($user)->put(
            "/books/{$book->id}",
            $this->validFields([
                "cover" => $coverFile,
            ])
        );

        $filepath = $this->bookCoversPath() . $coverFile->hashName();

        \Storage::assertExists($filepath);

        $this->assertLessThan($fullFileSize, \Storage::size($filepath));

        list($width, $height) = getimagesizefromstring(
            \Storage::get($filepath)
        );

        $this->assertEquals(200, $width);
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

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $cover = UploadedFile::fake()->createWithContent("cover.jpg", null);

        $response = $this->actingAs($user)->put(
            "/books/{$book->id}",
            $this->validFields([
                "cover" => $cover,
            ])
        );

        $response->assertStatus(500);
    }

    /**
     * @test
     */
    public function old_cover_is_deleted()
    {
        $user = User::factory()
            ->admin()
            ->create();

        Author::factory(2)->create();

        $book = Book::factory()->create($this->oldAttributes());

        $oldImagePath = $this->createOldCoverOnStorage();
        \Storage::assertExists($oldImagePath);

        $this->actingAs($user)->put("/books/{$book->id}", $this->validFields());

        \Storage::assertMissing($oldImagePath);
    }
}
