<?php

namespace App\Providers;

use App\Models\parent_category;
use App\Models\SitesDetails;
use Illuminate\Support\ServiceProvider;
use App\Services\GooglePlacesService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(GooglePlacesService::class, function ($app) {
            return new GooglePlacesService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $websiteData=SitesDetails::latest()->first();
        view()->share('websiteData',$websiteData);

        $mainCategories = parent_category::where('status',1)
        ->inRandomOrder()
        ->take(20)
        ->get(); 
        view()->share('footerCategories', $mainCategories);
    }
}
