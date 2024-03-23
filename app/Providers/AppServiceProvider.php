<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        ResetPassword::createUrlUsing(
            fn(object $notifiable, string $token) =>
            config('app.frontend_url') . "/password-reset/{$token}?email={$notifiable->getEmailForPasswordReset()}"
        );
    }
}
