<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get("/");

        $response->assertStatus(200);
    }
}
