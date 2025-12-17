<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use App\Traits\ProvidesCache;
use App\Traits\ProvidesSEO;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Level;
use App\Models\Program;
use App\Models\CategoryClass;
use App\Models\ReligiousAffiliationCategory;

class SearchController extends Controller
{
    use ProvidesCache;
    use ProvidesSEO;

    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $stateId = $request->input('location');
        $levelId = $request->input('level');
        $programId = $request->input('program');
        $typeSlug = $request->input('type');
        $categoryClassId = $request->input('category');
        $religionId = $request->input('religion');
        $sortBy = $request->input('sort');

        $state = $stateId ? State::find($stateId) : null;
        $level = $levelId ? Level::find($levelId) : null;
        $program = $programId ? Program::find($programId) : null;
        $typeSlug = in_array($typeSlug, ['public', 'federal', 'state', 'private', '']) ? $typeSlug : '';
        $categoryClass = $categoryClassId ? CategoryClass::find($categoryClassId) : null;
        $religiousAffiliationCategory = $religionId ? ReligiousAffiliationCategory::find($religionId) : null;
        $sortBy = in_array($sortBy, ['rank', 'za', '']) ? $sortBy : '';

        $sortOrder = match ($sortBy) {
            'rank' => 'Rank',
            'za' => 'Z - A',
            default => 'A - Z',
        };

        $cacheKey = 'search_'
            . 'location_' . ($stateId ?? 'null')
            . '_level_' . ($levelId ?? 'null')
            . '_program_' . ($programId ?? 'null')
            . '_type_' . ($typeSlug ?? 'null')
            . '_category_' . ($categoryClassId ?? 'null')
            . '_religion_' . ($religionId ?? 'null')
            . '_sort_' . ($sortBy ?? 'null')
            . request('page', 1);

        $institutions = $this->cache($cacheKey, 60 * 60, fn () => $this->searchService->search($request));

        $SEOData = $this->seo(
            title: "Search Nigerian Academic Institutions and Programs",
            description: "Use our advanced search to find universities, polytechnics, monotechnics, colleges of education, etc., and course programs in Nigeria that match your criteria. Filter by location, study level, programme, institution category and more.",
        );

        return view('search', compact('institutions', 'program', 'state', 'level', 'typeSlug', 'categoryClass', 'religiousAffiliationCategory', 'sortOrder', 'SEOData'));
    }
}
