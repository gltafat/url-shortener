<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ShortUrl;
use App\Policies\ShortUrlPolicy;


class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        ShortUrl::class => ShortUrlPolicy::class,
    ];
    
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
