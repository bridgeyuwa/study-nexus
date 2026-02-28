<?php

namespace App\Infrastructure\News\Repositories;

use App\Models\News;
use Illuminate\Support\Collection;

final class NewsRepository
{
    public function findSimilar(News $news): Collection
    {
        $newsCategoryIds = $news->newsCategories->pluck('id')->toArray();

        return News::whereHas('newsCategories', function ($query) use ($newsCategoryIds): void {
            $query->whereIn('news_categories.id', $newsCategoryIds);
        })
            ->where('id', '!=', $news->id)
            ->withCount(['newsCategories' => function ($query) use ($newsCategoryIds): void {
                $query->whereIn('news_categories.id', $newsCategoryIds);
            }])
            ->with(['institution', 'newsCategories'])
            ->orderBy('news_categories_count', 'desc')
            ->when($news->institution_id, function ($query) use ($news): void {
                $query->orderByRaw('institution_id = ? DESC', [$news->institution_id]);
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
}
