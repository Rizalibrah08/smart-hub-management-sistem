<?php

namespace App\Providers;

use App\Events\CheckInApproved;
use App\Listeners\SendCheckInNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Override system environment variables with .env values
        // This is needed when system env vars (e.g. DB_CONNECTION=sqlite) conflict with .env
        $overrides = [
            'DB_CONNECTION' => 'mysql',
            'DB_HOST'       => '127.0.0.1',
            'DB_PORT'       => '3306',
            'DB_DATABASE'   => 'dbshb',
            'DB_USERNAME'   => 'root',
            'DB_PASSWORD'   => '',
        ];
        foreach ($overrides as $key => $value) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }

    public function boot(): void
    {
        Event::listen(CheckInApproved::class, SendCheckInNotification::class);
    }
}
