<?php

namespace App\Http\Controllers\Concerns;

trait GeneratesShareLinks
{
    /**
     * Generate social media share links.
     *
     * @return array
     */
    public function shareLinks(): array
    {
        return \Share::currentPage()
            ->facebook()
            ->twitter()
            ->linkedin()
            ->reddit()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();
    }
}
