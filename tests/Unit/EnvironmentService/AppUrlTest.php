<?php

namespace Tests\Unit\EnvironmentService;

use App\EnvironmentService;
use Illuminate\Contracts\Console\Kernel;
use Tests\TestCase;

class AppUrlTest extends TestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . "/../../../bootstrap/app.php";

        $app->loadEnvironmentFrom("tests/Unit/EnvironmentService/.env.clear");
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    protected function setUp(): void
    {
        parent::setUp();

        putenv("LARAVEL_SAIL");
        putenv("APP_URL");
        putenv("APP_PORT");
    }

    /**
     * @test
     */
    public function getting_app_url_for_artisan_serve()
    {
        putenv("APP_URL=http://myurl:9000");

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
        putenv("LARAVEL_SAIL=1");
        $environmentService = app(EnvironmentService::class);
        $this->assertEquals("http://localhost", $environmentService->appUrl());
    }

    /**
     * @test
     */
    public function getting_default_app_url_for_sail_with_port_specified()
    {
        putenv("LARAVEL_SAIL=1");
        putenv("APP_PORT=8001");

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
        putenv("LARAVEL_SAIL=1");
        putenv("SAIL_APP_URL=http://my_cutom_url:8001");

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
        putenv("LARAVEL_SAIL=1");
        putenv("APP_PORT=8001");
        putenv("SAIL_APP_URL=http://my_cutom_url:8002");

        $environmentService = app(EnvironmentService::class);
        $this->assertEquals(
            "http://my_cutom_url:8002",
            $environmentService->appUrl()
        );
    }
}
