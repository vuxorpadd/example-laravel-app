<?php

namespace Tests\Unit\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CoverUrlTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getting_cover_url_when_cover_is_not_in_storage()
    {
        $book = Book::factory()->create([
            "cover" => "http://cover-image.png",
        ]);

        $this->assertEquals("http://cover-image.png", $book->cover_url);
    }

    /**
     * @test
     */
    public function getting_cover_url_when_cover_is_in_storage()
    {
        \Storage::fake();

        $image = UploadedFile::fake()->image("cover.jpg");
        $resourceName = "book-covers/" . $image->hashName();

        $book = Book::factory()->create([
            "cover" => $resourceName,
        ]);

        $this->assertEquals(\URL::to($resourceName), $book->cover_url);
    }
}
