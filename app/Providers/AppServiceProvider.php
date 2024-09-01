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
		
		
		View::composer('layouts.backend', function ($view) {
            
            $news = Cache::rememberForever('latest_news', function () {
                return News::select('id','title','created_at')->orderBy('created_at','desc')->take(5)->get();
            });
			
            $view->with([
			'news' => $news
			]);
        });
	   

    }
}
