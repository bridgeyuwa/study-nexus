<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ProvidesCache;
use App\Http\Controllers\Concerns\ProvidesSEO;
use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\Level;
use App\Models\Program;

class HomeController extends Controller
{
    use ProvidesCache;
    use ProvidesSEO;

    public function index()
    {
        $institutions = $this->cache('all_institutions', 60 * 60, fn () => Institution::all(), ['institutions']);

        $programs = $this->cache('all_programs', 60 * 60, fn () => Program::all(), ['programs']);

        $categoryClasses = $this->cache('all_category_classes', 60 * 60 * 24, fn () => CategoryClass::all(), ['category_classes']);

        $levels = $this->cache('all_levels', 60 * 60, fn () => Level::all(), ['levels']);

        $SEOData = $this->seo(
            title: 'Study Nexus - Your Gateway to Higher Education in Nigeria',
            description: 'Discover universities, polytechnics, monotechnics, and colleges of education in Nigeria. Explore the online directory academic programmes, rankings, News Updates and more on Study Nexus.'
        );

        return view('home', compact('institutions', 'programs', 'categoryClasses', 'levels', 'SEOData'));
    }
}
