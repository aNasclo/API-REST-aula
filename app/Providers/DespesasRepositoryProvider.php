<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DespesasRepository;
use App\Repositories\EloquentDespesasRepository;

class DespesasRepositoryProvider extends ServiceProvider
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
        DespesasRepository::class => EloquentDespesasRepository::class
    ];
}
