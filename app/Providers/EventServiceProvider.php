<?php

namespace App\Providers;

use App\Application\News\Listeners\LogNewsViewed;
use App\Domain\News\Events\NewsViewed;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewsViewed::class => [
            LogNewsViewed::class,
        ],
    ];
}
