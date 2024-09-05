<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Institution;
use App\Models\NewsCategory;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function index()
    {
        // Cache the paginated news items
        $news = Cache::remember('news_index', 60, function () {
            $newsItems = News::with(['newsCategories', 'institution'])->orderBy('created_at', 'desc')->paginate(10);
            $newsItems->getCollection()->transform(function ($newsItem) {
                $newsItem->readTime = $this->readTime($newsItem->content);
                return $newsItem;
            });
            return $newsItems;
        });

        // Cache the news categories with count
        $newsCategories = Cache::remember('news_categories_index', 60, function () {
            return NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get();
        });
		
		
		$SEOData = new SEOData(
            title: "Latest Education News",
            description: "Stay updated with the latest education news in Nigeria.",
        );
		
		
        return view('news.index', compact('news', 'newsCategories','SEOData'));
    }

    public function indexByInstitution(Institution $institution)
    {
        $news = Cache::remember("news_index_institution_{$institution->id}", 60, function () use ($institution) {
            $newsItems = $institution->news()->with('newsCategories')->orderBy('created_at', 'desc')->paginate(10);
            $newsItems->getCollection()->transform(function ($newsItem) {
                $newsItem->readTime = $this->readTime($newsItem->content);
                return $newsItem;
            });
            $newsItems->load(['institution']);
            return $newsItems;
        });

        $newsCategories = Cache::remember('news_categories_index_institution', 60, function () {
            return NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get();
        });
		
		
		$SEOData = new SEOData(
            title: "News from {$institution->name}",
            description: "Latest news updates from {$institution->name}.",
        );

        return view('news.index', compact('institution', 'news', 'newsCategories','SEOData'));
    }
	

    public function indexByNewsCategory(NewsCategory $newsCategory)
    {
        $news = Cache::remember("news_index_category_{$newsCategory->id}", 60, function () use ($newsCategory) {
            $newsItems = $newsCategory->news()->with('newsCategories')->orderBy('created_at', 'desc')->paginate(10);
            $newsItems->getCollection()->transform(function ($newsItem) {
                $newsItem->readTime = $this->readTime($newsItem->content);
                return $newsItem;
            });
            $newsItems->load(['institution']);
            return $newsItems;
        });

        $newsCategories = Cache::remember('news_categories_index_category', 60, function () {
            return NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get();
        });
		
		
		$SEOData = new SEOData(
            title: "News in {$newsCategory->name} Category",
            description: "Browse news articles in the {$newsCategory->name} category.",
        );

        return view('news.index', compact('newsCategory', 'news', 'newsCategories','SEOData'));
    }
	
	
					
	public function indexOfNewsCategories()
    {
		
		//to add cache
		
		$newsCategories = NewsCategory::all()->groupBy(function($newsCategory){
			return strtoupper(substr($newsCategory->name, 0, 1));
			
		})->sortKeys()
		->map(function($group){
			return $group->sortBy('name');
			
		});
		
		
		
		$SEOData = new SEOData(
            title: "All News Categories",
            description: "Comprehensive list of all news categories in alphabetical order",
        );
		
		return view('news.news-categories', compact( 'newsCategories','SEOData'));
	}

    public function show(News $news)
    {
        $news->readTime = $this->readTime($news->content);
		
		$SEOData = new SEOData(
            title: $news->title,
            description: $news->excerpt,
        );
		
        return view('news.show', compact('news','SEOData'));
    }

    public function showByInstitution(Institution $institution, News $news) 
    {
        if ($news->institution_id !== $institution->id) {
            abort(404);
        }

        $news->readTime = $this->readTime($news->content);
		
		$SEOData = new SEOData(
            title: $news->title,
            description: $news->excerpt,
        );
		
		$canonical = route('news.show', ['news' => $news]);
		
        return view('news.show', compact('news','SEOData','canonical'));
    }

    public function showByNewsCategory(NewsCategory $newsCategory, News $news)
    {
        if (!$newsCategory->news->contains($news->id)) {
            abort(404);
        }

        $news->readTime = $this->readTime($news->content);
		
		$SEOData = new SEOData(
            title: $news->title,
            description: $news->excerpt,
        );
		
		$canonical = route('news.show', ['news' => $news]);
		
        return view('news.show', compact('newsCategory', 'news','SEOData','canonical'));
    }

    protected function readTime($content)
    {
        $content = str_word_count(strip_tags($content));
        $minutes = ceil($content / 200);
        return $minutes;
    }
}
