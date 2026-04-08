<?php

namespace App\Actions\News;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

final class GetSimilarNewsAction
{
    public function execute(News $news): Collection
    {
        $newsCategoryIds = $news->newsCategories->pluck('id')->toArray();

        return Cache::remember('similar_news_'.$news->id, 60 * 60, function () use ($news, $newsCategoryIds) {
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
        });
    }
}
