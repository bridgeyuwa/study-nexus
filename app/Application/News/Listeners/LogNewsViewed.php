<?php

namespace App\Application\News\Listeners;

use App\Domain\News\Events\NewsViewed;
use Illuminate\Support\Facades\Log;

class LogNewsViewed
{
    public function handle(NewsViewed $event): void
    {
        Log::info('News viewed', ['news_id' => $event->news->id]);
    }
}
