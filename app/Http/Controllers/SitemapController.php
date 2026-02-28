<?php

namespace App\Http\Controllers;

use App\Application\Sitemap\Actions\GenerateSitemapAction;

class SitemapController extends Controller
{
    public function __construct(private readonly GenerateSitemapAction $generateSitemapAction)
    {
    }

    public function index()
    {
        $this->generateSitemapAction->execute();

        return response()->json(['message' => 'Sitemap generated successfully.']);
    }
}
