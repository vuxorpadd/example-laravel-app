<?php

namespace Tests\Unit\EnvironmentService;

use App\EnvironmentService;
use PHPUnit\Framework\TestCase;

class AppUrlTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_ENV = [];
    }

    /**
     * @test
     */
    public function getting_app_url_for_artisan_serve()
    {
        $_ENV["APP_URL"] = "http://myurl:9000";

        $environmentService = app(EnvironmentService::class);
        $this->assertEquals("http://myurl:9000", $environmentService->appUrl());
    }

    /**
     * @test
     */
    public function getting_default_app_url_for_artisan_serve()
    {
        $environmentService = app(EnvironmentService::class);
        $this->assertEquals(
            "http://localhost:8000",
            $environmentService->appUrl()
        );
    }

    /**
     * @test
     */
    public function getting_default_app_url_for_sail()
    {
        $_ENV["LARAVEL_SAIL"] = "1";
        $environmentService = app(EnvironmentService::class);
        $this->assertEquals("http://localhost", $environmentService->appUrl());
    }

    /**
     * @test
     */
    public function getting_default_app_url_for_sail_with_port_specified()
    {
        $_ENV["LARAVEL_SAIL"] = "1";
        $_ENV["APP_PORT"] = "8001";

        $environmentService = app(EnvironmentService::class);
        $this->assertEquals(
            "http://localhost:8001",
            $environmentService->appUrl()
        );
    }

    /**
     * @test
     */
    public function getting_app_url_for_sail()
    {
        $_ENV["LARAVEL_SAIL"] = "1";
        $_ENV["SAIL_APP_URL"] = "http://my_cutom_url:8001";

        $environmentService = app(EnvironmentService::class);
        $this->assertEquals(
            "http://my_cutom_url:8001",
            $environmentService->appUrl()
        );
    }

    /**
     * @test
     */
    public function app_url_takes_precedence_over_app_port()
    {
        $_ENV["LARAVEL_SAIL"] = "1";
        $_ENV["APP_PORT"] = "8001";
        $_ENV["SAIL_APP_URL"] = "http://my_cutom_url:8002";

        $environmentService = app(EnvironmentService::class);
        $this->assertEquals(
            "http://my_cutom_url:8002",
            $environmentService->appUrl()
        );
    }
}
