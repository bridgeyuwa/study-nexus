<?php

namespace App\Application\News\Actions;

use App\Infrastructure\News\Repositories\NewsRepository;
use App\Models\News;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final readonly class GetSimilarNewsAction
{
    public function __construct(private NewsRepository $newsRepository)
    {
    }

    public function execute(News $news): Collection
    {
        return Cache::remember(
            'similar_news_'.$news->id,
            60 * 60,
            fn () => $this->newsRepository->findSimilar($news)
        );
    }
}
