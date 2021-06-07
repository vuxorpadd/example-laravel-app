<?php

namespace Tests\Unit\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CoverPathTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getting_cover_path_when_cover_is_not_in_storage()
    {
        $book = Book::factory()->create([
            "cover" => "http://cover-image.png",
        ]);

        $this->assertEquals(null, $book->cover_path);
    }

    /**
     * @test
     */
    public function getting_cover_path_when_cover_is_in_storage()
    {
        \Storage::fake();

        $image = UploadedFile::fake()->image("cover.jpg");
        $resourceName = "book-covers/" . $image->hashName();

        \Storage::putFile($resourceName, $image);

        $book = Book::factory()->create([
            "cover" => $resourceName,
        ]);

        $this->assertEquals(\Storage::path($resourceName), $book->cover_path);
    }
}
