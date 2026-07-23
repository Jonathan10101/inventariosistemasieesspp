<?php

namespace App\Providers;

use Livewire\Livewire;
use Livewire\Features\SupportFileUploads\FilePreviewController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Route;


use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    
        /*
        Paginator::useBootstrapFour();
        Gate::define('viewPulse', function (User $user): bool {
            return $user->email === config('services.pulse.admin_email');
        });
        */
         Gate::define('viewPulse', function (User $user): bool {
            return $user->email === config('services.pulse.admin_email');
        });
        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle)
                ->middleware([
                    'web',
                    InitializeTenancyByDomain::class,
                ]);
        });

        FilePreviewController::$middleware = [
            'web',
            InitializeTenancyByDomain::class,
        ];
        Paginator::useBootstrapFour();

    }

    
}
