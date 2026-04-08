<?php

use App\Providers\AppServiceProvider;
use App\Providers\NovaServiceProvider;
use Lukeraymonddowning\SelfHealingUrls\Providers\SelfHealingUrlsServiceProvider;

return [
    AppServiceProvider::class,
    NovaServiceProvider::class,
    SelfHealingUrlsServiceProvider::class,
];
