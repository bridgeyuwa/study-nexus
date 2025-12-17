<?php

namespace App\Http\Controllers\Concerns;

use RalphJSmit\Laravel\SEO\Support\SEOData;

trait ProvidesSEO
{
    /**
     * Generate SEO data.
     *
     * @param  string  $title
     * @param  string  $description
     * @return \RalphJSmit\Laravel\SEO\Support\SEOData
     */
    public function seo(string $title, string $description): SEOData
    {
        return new SEOData(
            title: $title,
            description: $description
        );
    }
}
