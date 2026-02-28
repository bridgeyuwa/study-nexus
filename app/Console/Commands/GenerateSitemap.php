<?php

namespace App\Console\Commands;

use App\Application\Sitemap\Actions\GenerateSitemapAction;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap';

    public function handle(GenerateSitemapAction $generateSitemapAction): void
    {
        $generateSitemapAction->execute();

        $this->info('Sitemap generated successfully');
    }
}
