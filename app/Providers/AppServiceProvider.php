<?php

namespace App\Providers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        setlocale(LC_TIME, 'fr_FR.UTF-8');
        Carbon::setLocale('fr');

        Model::preventLazyLoading(! app()->isProduction());

        Gate::define('viewPulse', fn (User $user) => $user->canAccessPulse());
    }
}
