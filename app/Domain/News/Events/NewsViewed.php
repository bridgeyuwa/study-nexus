<?php

namespace App\Domain\News\Events;

use App\Models\News;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewsViewed
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public readonly News $news)
    {
    }
}
