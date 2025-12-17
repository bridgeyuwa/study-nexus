<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Program;
use App\Models\CategoryClass;
use App\Models\Level;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache the results of the queries
        $institutions = Cache::tags(['institutions'])->remember('all_institutions', 60 * 60, function () {
            return Institution::all();
        });

        $programs = Cache::tags(['programs'])->remember('all_programs', 60 * 60, function () {
            return Program::all();
        });

        $categoryClasses = Cache::tags(['category_classes'])->remember('all_category_classes', 60 * 60 * 24, function () {
            return CategoryClass::all();
        });

        $levels = Cache::tags(['levels'])->remember('all_levels', 60 * 60, function () {
            return Level::all();
        });

        $SEOData = new SEOData(
            description: "Discover universities, polytechnics, monotechnics, and colleges of education in Nigeria. Explore the online directory academic programmes, rankings, News Updates and more on Study Nexus."
        );

        return view('home', compact('institutions', 'programs', 'categoryClasses', 'levels', 'SEOData'));
    }
}
