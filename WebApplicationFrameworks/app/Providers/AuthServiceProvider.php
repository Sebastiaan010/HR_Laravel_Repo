<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Koppel model → jouw “rechten”-klasse.
     */
    protected $policies = [
        \App\Models\ForumPost::class => \App\Rechten\ForumPostRechten::class,
    ];

    public function boot(): void
    {
        // Niks nodig; de mapping hierboven is genoeg.
    }
}
