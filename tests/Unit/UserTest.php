<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function is_admin_works_correctly()
    {
        $user = User::factory()
            ->admin()
            ->create();

        $this->assertTrue($user->isAdmin());
    }

    /**
     * @test
     */
    public function not_admin_works_correctly()
    {
        $user = User::factory()
            ->user()
            ->create();

        $this->assertTrue($user->notAdmin());
    }
}
