<?php

namespace App\Services;

use App\Models\News;

class NewsService
{
    public function getSimilarNews(News $news)
    {
        $newsCategoryIds = $news->newsCategories->pluck('id')->toArray();

        return News::whereHas('newsCategories', function ($query) use ($newsCategoryIds) {
            $query->whereIn('news_categories.id', $newsCategoryIds);
        })
            ->where('id', '!=', $news->id)
            ->withCount(['newsCategories' => function ($query) use ($newsCategoryIds) {
                $query->whereIn('news_categories.id', $newsCategoryIds);
            }])
            ->with(['institution', 'newsCategories'])
            ->orderBy('news_categories_count', 'desc')
            ->when($news->institution_id, function ($query) use ($news) {
                $query->orderByRaw('institution_id = ? DESC', [$news->institution_id]);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
}
