<?php

namespace App\Providers;

use App\Models\LaporanKeuangan;
use App\Models\ProfilBumnag;
use App\Policies\LaporanKeuanganPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Register policies
        Gate::policy(LaporanKeuangan::class, LaporanKeuanganPolicy::class);

        // Share logo URL globally to all views
        View::composer('*', function ($view) {
            if (!isset($view->getData()['logoUrl'])) {
                // Cache the logo info per request to avoid repeated DB queries
                static $logoUrl = null;
                static $logoPath = null;

                if ($logoUrl === null) {
                    $profil = ProfilBumnag::first();
                    $logoFile = $profil?->logo;

                    // Check if uploaded logo exists
                    if ($logoFile && file_exists(public_path('uploads/' . $logoFile))) {
                        $logoUrl = asset('uploads/' . $logoFile);
                        $logoPath = public_path('uploads/' . $logoFile);
                    } else {
                        // Fallback to default static logo
                        $logoUrl = asset('images/logo.png');
                        $logoPath = public_path('images/logo.png');
                    }
                }

                $view->with('logoUrl', $logoUrl);
                $view->with('logoPath', $logoPath);
            }
        });
    }
}
