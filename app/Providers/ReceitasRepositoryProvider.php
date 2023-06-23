<?php

namespace App\Providers;

use App\Repositories\ReceitasRepository;
use App\Repositories\EloquentReceitasRepository;
use Illuminate\Support\ServiceProvider;

class ReceitasRepositoryProvider extends ServiceProvider
{
    // /**
    //  * Register services.
    //  */
    // public function register(): void
    // {
    //     //
    // }

    // /**
    //  * Bootstrap services.
    //  */
    // public function boot(): void
    // {
    //     //
    // }

    public array $bindings = [
        ReceitasRepository::class => EloquentReceitasRepository::class
    ];
}
