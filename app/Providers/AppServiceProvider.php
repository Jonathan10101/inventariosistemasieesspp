<?php

namespace App\Providers;

use Livewire\Livewire;
use Livewire\Features\SupportFileUploads\FilePreviewController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;



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
    

        Paginator::useBootstrapFour();
        Gate::define('viewPulse', function (User $user): bool {
            return $user->email === config('services.pulse.admin_email');
        });

    }
}
