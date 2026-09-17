<?php

namespace App\Providers;

use Livewire\Livewire;
use Livewire\Features\SupportFileUploads\FilePreviewController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Listeners\ActivateSingleUserSession;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;

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
        Event::listen(
            Login::class,
            ActivateSingleUserSession::class
        );

        Gate::define('viewPulse', function (User $user): bool {
            $userEmail = mb_strtolower(
                trim((string) $user->email)
            );

            $adminEmail = mb_strtolower(
                trim((string) config('services.pulse.admin_email'))
            );

            return $adminEmail !== ''
                && $userEmail === $adminEmail;
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
