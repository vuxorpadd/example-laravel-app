<?php

namespace Tests\Unit;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorToJsonTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function birthdate_is_in_correct_format()
    {
        $author = Author::factory()->create([
            "birthdate" => Carbon::parse("1960-01-01"),
        ]);

        $authorJsonObject = json_decode($author->toJson());

        $this->assertEquals("1960-01-01", $authorJsonObject->birthdate);
    }
}
