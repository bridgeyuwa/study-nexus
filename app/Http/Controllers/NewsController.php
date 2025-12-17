<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Institution;
use App\Models\NewsCategory;
use App\Services\NewsService;
use App\Traits\ProvidesCache;
use App\Traits\ProvidesSEO;
use App\Traits\GeneratesShareLinks;

class NewsController extends Controller
{
    use ProvidesCache;
    use ProvidesSEO;
    use GeneratesShareLinks;

    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index()
    {
        $news = $this->cache('news_index_page_'.request('page', 1), 15 * 60, fn () => News::with(['newsCategories', 'institution'])->orderBy('created_at', 'desc')->paginate(10));

        $newsCategories = $this->cache('news_categories_index', 60 * 60, fn () => NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get());

        $SEOData = $this->seo(
            title: "Latest Education News",
            description: "Stay updated with the latest education news in Nigeria.",
        );

        return view('news.index', compact('news', 'newsCategories', 'SEOData'));
    }

    public function indexByInstitution(Institution $institution)
    {
        $news = $this->cache("news_index_institution_{$institution->id}", 15 * 60, fn () => $institution->news()->with('newsCategories')->orderBy('created_at', 'desc')->paginate(10));

        $newsCategories = $this->cache('news_categories_index_institution', 60 * 60, fn () => NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get());

        $SEOData = $this->seo(
            title: "News from {$institution->name}",
            description: "Latest news updates from {$institution->name}.",
        );

        return view('news.index', compact('institution', 'news', 'newsCategories', 'SEOData'));
    }

    public function indexByNewsCategory(NewsCategory $newsCategory)
    {
        $news = $this->cache("news_index_category_{$newsCategory->id}", 15 * 60, fn () => $newsCategory->news()->with('newsCategories')->orderBy('created_at', 'desc')->paginate(10));

        $newsCategories = $this->cache('news_categories_index_category', 60 * 60, fn () => NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get());

        $SEOData = $this->seo(
            title: "News in {$newsCategory->name} Category",
            description: "Browse news articles in the {$newsCategory->name} category.",
        );

        return view('news.index', compact('newsCategory', 'news', 'newsCategories', 'SEOData'));
    }

    public function indexOfNewsCategories()
    {
        $newsCategories = $this->cache('news_categories', 60 * 60, fn () => NewsCategory::all()->groupBy(fn ($newsCategory) => strtoupper(substr($newsCategory->name, 0, 1)))
            ->sortKeys()
            ->map(fn ($group) => $group->sortBy('name')));

        $SEOData = $this->seo(
            title: "All News Categories",
            description: "Comprehensive list of all news categories in alphabetical order",
        );

        return view('news.news-categories', compact('newsCategories', 'SEOData'));
    }

    public function show(News $news)
    {
        $SEOData = $this->seo(
            title: $news->title,
            description: $news->excerpt,
        );

        $cacheKey = 'similar_news_' . $news->id;
        $similarNews = $this->cache($cacheKey, 60 * 60, fn () => $this->newsService->getSimilarNews($news));

        $shareLinks = $this->shareLinks();

        return view('news.show', compact('news', 'similarNews', 'SEOData', 'shareLinks'));
    }

    public function showByInstitution(Institution $institution, News $news)
    {
        if ($news->institution_id !== $institution->id) {
            abort(404);
        }

        $SEOData = $this->seo(
            title: $news->title,
            description: $news->excerpt,
        );

        $cacheKey = 'similar_news_' . $news->id;
        $similarNews = $this->cache($cacheKey, 60 * 60, fn () => $this->newsService->getSimilarNews($news));

        $canonical = route('news.show', ['news' => $news]);

        $shareLinks = $this->shareLinks();

        return view('news.show', compact('news', 'SEOData', 'similarNews', 'canonical', 'shareLinks'));
    }

    public function showByNewsCategory(NewsCategory $newsCategory, News $news)
    {
        if (! $newsCategory->news->contains($news->id)) {
            abort(404);
        }

        $SEOData = $this->seo(
            title: $news->title,
            description: $news->excerpt,
        );

        $cacheKey = 'similar_news_' . $news->id;
        $similarNews = $this->cache($cacheKey, 60 * 60, fn () => $this->newsService->getSimilarNews($news));

        $canonical = route('news.show', ['news' => $news]);

        $shareLinks = $this->shareLinks();

        return view('news.show', compact('newsCategory', 'news', 'SEOData', 'similarNews', 'canonical', 'shareLinks'));
    }
}
