<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use App\Models\CategoryClass;
use App\Models\Level;
use App\Models\News;
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
	   Model::preventAccessingMissingAttributes();
	   
	   View::composer('partials.side-bar', function ($view) {
			// Cache the category classes for 15 minutes
			$categoryClasses = Cache::remember('category_classes', 24 * 60 * 60, function () {
				return CategoryClass::all();
			});

			// Cache the levels for 15 minutes
			$levels = Cache::remember('levels', 24 * 60 * 60, function () {
				return Level::all();
			});
			
			$view->with([
				'categoryClasses' => $categoryClasses,
				'levels' => $levels
			]);
		});

		
		View::composer('layouts.backend', function ($view) {
            // manually remove this cach when added new News Article
            $news = Cache::remember('latest_news', 15 * 60, function () {
                return News::select('id','title','created_at')->orderBy('created_at','desc')->take(4)->get();
            });
			
            $view->with([
			'news' => $news
			]);
        });
	   

    }
}
