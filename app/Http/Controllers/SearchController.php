<?php

namespace App\Http\Controllers;

use App\DTOs\SearchFiltersData;
use App\Models\CategoryClass;
use App\Models\Level;
use App\Models\Program;
use App\Models\ReligiousAffiliationCategory;
use App\Models\State;
use App\Queries\InstitutionSearchQuery;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SearchController extends Controller
{
    public function __construct(
        private readonly InstitutionSearchQuery $query,
    ) {}

    public function index(Request $request): View
    {
        $typeSlug = $request->input('type');
        $typeSlug = in_array($typeSlug, ['public', 'federal', 'state', 'private', '']) ? $typeSlug : '';

        $sortBy = $request->input('sort');
        $sortBy = in_array($sortBy, ['rank', 'za', '']) ? $sortBy : '';

        $state = ($stateId = $request->input('location')) ? State::find($stateId) : null;
        $level = ($levelId = $request->input('level')) ? Level::find($levelId) : null;
        $program = ($programId = $request->input('program')) ? Program::find($programId) : null;
        $categoryClass = ($categoryClassId = $request->input('category')) ? CategoryClass::find($categoryClassId) : null;
        $religiousAffiliationCategory = ($religionId = $request->input('religion')) ? ReligiousAffiliationCategory::find($religionId) : null;

        $sortOrder = match ($sortBy) {
            'rank' => 'Rank',
            'za' => 'Z - A',
            default => 'A - Z',
        };

        $filters = new SearchFiltersData(
            state: $state,
            level: $level,
            program: $program,
            typeSlug: $typeSlug,
            categoryClass: $categoryClass,
            religiousAffiliationCategory: $religiousAffiliationCategory,
            sortBy: $sortBy,
            page: (int) $request->input('page', 1),
        );

        $institutions = $this->query->execute($filters);
        $institutions->appends($request->except('page'));

        $SEOData = new SEOData(
            title: 'Search Nigerian Academic Institutions and Programs',
            description: 'Use our advanced search to find universities, polytechnics, monotechnics, colleges of education, etc., and course programs in Nigeria that match your criteria. Filter by location, study level, programme, institution category and more.',
        );

        return view('search', compact('institutions', 'program', 'state', 'level', 'typeSlug', 'categoryClass', 'religiousAffiliationCategory', 'sortOrder', 'SEOData'));
    }
}
