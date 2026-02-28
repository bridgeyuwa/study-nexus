<?php

namespace App\Http\Controllers;

use App\Application\Search\Actions\SearchInstitutionsAction;
use App\Application\Search\Data\SearchInstitutionsData;
use App\Models\CategoryClass;
use App\Models\Level;
use App\Models\Program;
use App\Models\ReligiousAffiliationCategory;
use App\Models\State;
use App\UI\ViewModels\SeoDataViewModel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, SearchInstitutionsAction $searchInstitutionsAction)
    {
        $filters = SearchInstitutionsData::fromRequest($request);

        $state = $filters->location ? State::find($filters->location) : null;
        $level = $filters->level ? Level::find($filters->level) : null;
        $program = $filters->program ? Program::find($filters->program) : null;
        $categoryClass = $filters->category ? CategoryClass::find($filters->category) : null;
        $religiousAffiliationCategory = $filters->religion ? ReligiousAffiliationCategory::find($filters->religion) : null;

        $institutions = $searchInstitutionsAction->execute($filters)
            ->appends($request->except('page'));

        $SEOData = SeoDataViewModel::make(
            title: 'Search Nigerian Academic Institutions and Programs',
            description: 'Use our advanced search to find universities, polytechnics, monotechnics, colleges of education, etc., and course programs in Nigeria that match your criteria. Filter by location, study level, programme, institution category and more.'
        );

        return view('search', [
            'institutions' => $institutions,
            'program' => $program,
            'state' => $state,
            'level' => $level,
            'typeSlug' => $filters->type,
            'categoryClass' => $categoryClass,
            'religiousAffiliationCategory' => $religiousAffiliationCategory,
            'sortOrder' => $filters->sort->label(),
            'SEOData' => $SEOData,
        ]);
    }
}
