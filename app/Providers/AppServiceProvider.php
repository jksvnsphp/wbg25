<?php

namespace App\Providers;

use App\Models\parent_category;
use App\Models\SitesDetails;
use Illuminate\Support\ServiceProvider;
use App\Services\GooglePlacesService;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
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
    /*
    |--------------------------------------------------------------------------
    | Website Global Data
    |--------------------------------------------------------------------------
    */
    $websiteData = SitesDetails::latest()->first();
    View::share('websiteData', $websiteData);

    /*
    |--------------------------------------------------------------------------
    | Footer Categories
    |--------------------------------------------------------------------------
    */
    $footerCategories = parent_category::where('status', 1)
        ->inRandomOrder()
        ->limit(20)
        ->get();

    View::share('footerCategories', $footerCategories);

    /*
    |--------------------------------------------------------------------------
    | Global SEO Composer
    |--------------------------------------------------------------------------
    */
    View::composer('*', function ($view) {
        if (!isset($view->seo)) {
            $view->with('seo', seo(request()->segment(1) ?? 'home'));
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Global Cart Count
    |--------------------------------------------------------------------------
    */
    View::composer('*', function ($view) {
        $cartCount = auth()->check()
            ? Cart::where('user_id', auth()->id())->sum('quantity')
            : 0;

        $view->with('cartCount', $cartCount);
    });
}

}
