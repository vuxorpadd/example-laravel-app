<?php

namespace App;

class EnvironmentService
{
    public function appUrl(): string
    {
        if (env("LARAVEL_SAIL")) {
            $port = env("APP_PORT", null);
            $defaultUrl = "http://localhost";

            if ($port) {
                $defaultUrl .= ":{$port}";
            }

            return env("SAIL_APP_URL", $defaultUrl);
        }

        return env("APP_URL", "http://localhost:8000");
    }

    public function mailMailer()
    {
        return env("LARAVEL_SAIL")
            ? env("SAIL_MAIL_MAILER", "smtp")
            : env("MAIL_MAILER", "smtp");
    }
}
