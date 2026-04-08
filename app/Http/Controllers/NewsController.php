<?php

namespace App\Http\Controllers;

use App\Actions\News\ComputeReadTimeAction;
use App\Actions\News\GetSimilarNewsAction;
use App\Models\Institution;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class NewsController extends Controller
{
    public function __construct(
        private readonly GetSimilarNewsAction $similarNews,
        private readonly ComputeReadTimeAction $readTime,
    ) {}

    public function index()
    {
        $news = Cache::remember('news_index_page_'.request('page', 1), 15 * 60, function () {
            $newsItems = News::with(['newsCategories', 'institution'])->orderBy('created_at', 'desc')->paginate(10);
            $newsItems->getCollection()->transform(function ($newsItem) {
                $newsItem->readTime = $this->readTime->execute($newsItem->content);

                return $newsItem;
            });

            return $newsItems;
        });

        $newsCategories = $this->getNewsCategories();

        $SEOData = new SEOData(
            title: 'Latest Education News',
            description: 'Stay updated with the latest education news in Nigeria.',
        );

        return view('news.index', compact('news', 'newsCategories', 'SEOData'));
    }

    public function indexByInstitution(Institution $institution)
    {
        $news = Cache::remember("news_index_institution_{$institution->id}", 15 * 60, function () use ($institution) {
            $newsItems = $institution->news()->with('newsCategories')->orderBy('created_at', 'desc')->paginate(10);
            $newsItems->getCollection()->transform(function ($newsItem) {
                $newsItem->readTime = $this->readTime->execute($newsItem->content);

                return $newsItem;
            });
            $newsItems->load(['institution']);

            return $newsItems;
        });

        $newsCategories = $this->getNewsCategories();

        $SEOData = new SEOData(
            title: "News from {$institution->name}",
            description: "Latest news updates from {$institution->name}.",
        );

        return view('news.index', compact('institution', 'news', 'newsCategories', 'SEOData'));
    }

    public function indexByNewsCategory(NewsCategory $newsCategory)
    {
        $news = Cache::remember("news_index_category_{$newsCategory->id}", 15 * 60, function () use ($newsCategory) {
            $newsItems = $newsCategory->news()->with('newsCategories')->orderBy('created_at', 'desc')->paginate(10);
            $newsItems->getCollection()->transform(function ($newsItem) {
                $newsItem->readTime = $this->readTime->execute($newsItem->content);

                return $newsItem;
            });
            $newsItems->load(['institution']);

            return $newsItems;
        });

        $newsCategories = $this->getNewsCategories();

        $SEOData = new SEOData(
            title: "News in {$newsCategory->name} Category",
            description: "Browse news articles in the {$newsCategory->name} category.",
        );

        return view('news.index', compact('newsCategory', 'news', 'newsCategories', 'SEOData'));
    }

    public function indexOfNewsCategories()
    {
        $newsCategories = Cache::remember('news_categories', 60 * 60, function () {
            return NewsCategory::all()->groupBy(function ($newsCategory) {
                return strtoupper(substr($newsCategory->name, 0, 1));
            })->sortKeys()
                ->map(function ($group) {
                    return $group->sortBy('name');
                });
        });

        $SEOData = new SEOData(
            title: 'All News Categories',
            description: 'Comprehensive list of all news categories in alphabetical order',
        );

        return view('news.news-categories', compact('newsCategories', 'SEOData'));
    }

    public function show(News $news)
    {
        $news->readTime = $this->readTime->execute($news->content);

        $SEOData = new SEOData(
            title: $news->title,
            description: $news->excerpt,
        );

        $similarNews = $this->similarNews->execute($news);

        $shareLinks = \Share::currentPage()
            ->facebook()
            ->twitter()
            ->linkedin()
            ->reddit()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return view('news.show', compact('news', 'similarNews', 'SEOData', 'shareLinks'));
    }

    public function showByInstitution(Institution $institution, News $news)
    {
        if ($news->institution_id !== $institution->id) {
            abort(404);
        }

        $news->readTime = $this->readTime->execute($news->content);

        $SEOData = new SEOData(
            title: $news->title,
            description: $news->excerpt,
        );

        $similarNews = $this->similarNews->execute($news);

        $canonical = route('news.show', ['news' => $news]);

        $shareLinks = \Share::currentPage()
            ->facebook()
            ->reddit()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return view('news.show', compact('news', 'SEOData', 'similarNews', 'canonical', 'shareLinks'));
    }

    public function showByNewsCategory(NewsCategory $newsCategory, News $news)
    {
        if (! $newsCategory->news->contains($news->id)) {
            abort(404);
        }

        $news->readTime = $this->readTime->execute($news->content);

        $SEOData = new SEOData(
            title: $news->title,
            description: $news->excerpt,
        );

        $similarNews = $this->similarNews->execute($news);

        $canonical = route('news.show', ['news' => $news]);

        $shareLinks = \Share::currentPage()
            ->facebook()
            ->twitter()
            ->linkedin()
            ->reddit()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return view('news.show', compact('newsCategory', 'news', 'SEOData', 'similarNews', 'canonical', 'shareLinks'));
    }

    private function getNewsCategories(): Collection
    {
        return Cache::remember('news_categories_index', 60 * 60, function () {
            return NewsCategory::withCount('news')->orderBy('news_count', 'desc')->take(25)->get();
        });
    }
}
