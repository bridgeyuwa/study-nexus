<?php

namespace App\UI\ViewModels;

use RalphJSmit\Laravel\SEO\Support\SEOData;

final class SeoDataViewModel
{
    public static function make(?string $title = null, ?string $description = null): SEOData
    {
        return new SEOData(title: $title, description: $description);
    }
}
