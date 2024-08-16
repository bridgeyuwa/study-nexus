<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use App\Models\CategoryClass;
use App\Models\Level;
use Illuminate\Support\Facades\Cache;

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

       Paginator::defaultView('vendor.pagination.study-nexus');
        
	   Model::preventLazyLoading( !$this->app->isProduction());
	   
	   
	   View::composer('partials.side-bar', function ($view) {
            $categoryClasses = Cache::rememberForever('category_classes', function () {
                return CategoryClass::all();
            });

            $levels = Cache::rememberForever('levels', function () {
                return Level::all();
            });
			
            $view->with([
			'categoryClasses' => $categoryClasses,
			'levels' => $levels
			]);
        });
	   

    }
}
