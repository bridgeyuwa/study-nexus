<?php

namespace App\Http\Controllers;

use App\Models\CategoryClass;
use App\Models\Institution;
use App\Models\Level;
use App\Models\Program;
use App\Models\Region;
use App\Models\State;
use App\Traits\GeneratesShareLinks;
use App\Traits\ProvidesCache;
use App\Traits\ProvidesSEO;

class InstitutionController extends Controller
{
    use GeneratesShareLinks;
    use ProvidesCache;
    use ProvidesSEO;

    public function index()
    {
        $institutions = $this->cache('institutions_page_'.request('page', 1), 60 * 60, fn () => Institution::with(['state', 'institutionType', 'category'])
            ->orderBy('name')
            ->paginate(60));

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $SEOData = $this->seo(
            title: 'Higher Institutions in Nigeria',
            description: 'Browse a comprehensive list of universities, polytechnics, monotechnics, and colleges of education. Find the best institution for your needs.',
        );

        $parameters = ['location' => '', 'level' => '', 'program' => '', 'category' => ''];

        $shareLinks = $this->shareLinks();

        return view('institution.index', compact('institutions', 'categoryClasses', 'SEOData', 'parameters', 'shareLinks'));
    }

    public function category(CategoryClass $categoryClass)
    {
        $institutions = $this->cache('institutions_category_'.$categoryClass->id.'_page_'.request('page', 1), 60 * 60, fn () => $categoryClass->institutions()
            ->with(['state', 'institutionType', 'category'])
            ->orderBy('name')
            ->paginate(60));

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $SEOData = $this->seo(
            title: "{$categoryClass->name_plural} in Nigeria",
            description: "Browse a comprehensive list of {$categoryClass->name_plural}. Find the best {$categoryClass->name} for your needs.",
        );

        $parameters = ['location' => '', 'level' => '', 'program' => '', 'category' => $categoryClass->id];

        $shareLinks = $this->shareLinks();

        return view('institution.index', compact('institutions', 'categoryClass', 'categoryClasses', 'SEOData', 'parameters', 'shareLinks'));
    }

    public function location()
    {
        $regions = $this->cache('regions_with_institutions', 60 * 60, fn () => Region::with(['institutions', 'states.institutions'])->get());

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $SEOData = $this->seo(
            title: 'Higher Institutions in Nigeria by Location',
            description: 'Discover academic institutions in your preferred location. Find the best educational institutions near you.',
        );

        $categoryClass = null;

        $shareLinks = $this->shareLinks();

        return view('institution.location', compact('regions', 'categoryClass', 'categoryClasses', 'SEOData', 'shareLinks'));
    }

    public function categoryLocation(CategoryClass $categoryClass)
    {
        $categoryIds = $categoryClass->categories->pluck('id');

        $regions = $this->cache("regions_with_institutions_for_category_{$categoryClass->id}", 60 * 60, fn () => Region::with([
            'institutions' => fn ($query) => $query->whereIn('category_id', $categoryIds),
            'states.institutions' => fn ($query) => $query->whereIn('category_id', $categoryIds),
        ])->get());

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $SEOData = $this->seo(
            title: "{$categoryClass->name_plural} in Nigeria by Location",
            description: "Discover {$categoryClass->name_plural} in your preferred location. Find the best educational institutions near you.",
        );

        $shareLinks = $this->shareLinks();

        return view('institution.location', compact('regions', 'categoryClass', 'categoryClasses', 'SEOData', 'shareLinks'));
    }

    public function showLocation(State $state)
    {
        $institutions = $this->cache("institutions_in_{$state->id}", 24 * 60 * 60, fn () => $state->institutions()
            ->with('category', 'institutionType', 'state')
            ->orderBy('name')
            ->get());

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $SEOData = $this->seo(
            title: 'Higher Institutions in '.$state->name.($state->is_state !== null ? ' State' : '').', Nigeria',
            description: 'Explore top institutions in '.$state->name.($state->is_state !== null ? ' State' : '').', Nigeria. Compare programmes and find the best fit for your education needs.'
        );

        $parameters = ['location' => $state->id, 'level' => '', 'program' => '', 'category' => ''];

        $shareLinks = $this->shareLinks();

        return view('institution.show-location', compact('state', 'institutions', 'categoryClasses', 'SEOData', 'parameters', 'shareLinks'));
    }

    public function showCategoryLocation(CategoryClass $categoryClass, State $state)
    {
        $categoryIds = $categoryClass->categories->pluck('id');

        $institutions = $this->cache("institutions_in_state_{$state->id}_for_category_{$categoryClass->id}", 60 * 60, fn () => $state->institutions()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'institutionType', 'state'])
            ->orderBy('name')
            ->get());

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $SEOData = $this->seo(
            title: "{$categoryClass->name_plural} in ".$state->name.($state->is_state !== null ? ' State' : '').', Nigeria',
            description: "Explore {$categoryClass->name_plural} in ".$state->name.($state->is_state !== null ? ' State' : '').', Nigeria. Compare programs and find the best fit for your education needs.',
        );

        $parameters = ['location' => $state->id, 'level' => '', 'program' => '', 'category' => $categoryClass->id];

        $shareLinks = $this->shareLinks();

        return view('institution.show-location', compact('state', 'institutions', 'categoryClass', 'categoryClasses', 'SEOData', 'parameters', 'shareLinks'));
    }

    public function institutionRanking(CategoryClass $categoryClass)
    {
        $institutions = $this->cache("institution_ranking_for_category_{$categoryClass->id}_page_".request('page', 1), 60 * 60, fn () => Institution::whereIn('category_id', $categoryClass->categories->pluck('id'))
            ->whereNotNull('rank')
            ->with(['state.region', 'category.categoryClass', 'state.institutions', 'state.region.institutions'])
            ->orderBy('rank')
            ->paginate(100));

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $rank = $institutions->isNotEmpty() ? $this->computeRankings($institutions) : null;

        $SEOData = $this->seo(
            title: "{$categoryClass->name_plural} Rankings in Nigeria",
            description: "Discover the top-ranked {$categoryClass->name_plural} in Nigeria. Compare rankings and find the best schools in the country.",
        );

        $shareLinks = $this->shareLinks();

        return view('institution.ranking', compact('institutions', 'rank', 'categoryClass', 'categoryClasses', 'SEOData', 'shareLinks'));
    }

    public function stateRanking(CategoryClass $categoryClass, State $state)
    {
        $institutions = $this->cache("state_ranking_for_category_{$categoryClass->id}_state_{$state->id}_page_".request('page', 1), 24 * 60 * 60, fn () => Institution::where('state_id', $state->id)
            ->whereIn('category_id', $categoryClass->categories->pluck('id'))
            ->whereNotNull('rank')
            ->with(['state.region', 'category.categoryClass', 'state.institutions', 'state.region.institutions'])
            ->orderBy('rank')
            ->paginate(100));

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $rank = $institutions->isNotEmpty() ? $this->computeRankings($institutions) : null;

        $SEOData = $this->seo(
            title: "{$categoryClass->name_plural} Rankings in ".$state->name.($state->is_state !== null ? ' State' : '').', Nigeria',
            description: "Discover the top-ranked {$categoryClass->name_plural} in ".$state->name.($state->is_state !== null ? ' State' : '').', Nigeria. Compare rankings and find the best schools in the state.',
        );

        $shareLinks = $this->shareLinks();

        return view('institution.ranking', compact('institutions', 'rank', 'categoryClass', 'categoryClasses', 'state', 'SEOData', 'shareLinks'));
    }

    public function regionRanking(CategoryClass $categoryClass, Region $region)
    {
        $institutions = $this->cache("region_ranking_for_category_{$categoryClass->id}_region_{$region->id}_page_".request('page', 1), 24 * 60 * 60, fn () => Institution::whereIn('category_id', $categoryClass->categories->pluck('id'))
            ->whereHas('state.region', fn ($query) => $query->where('region_id', $region->id))
            ->whereNotNull('rank')
            ->with(['state.region', 'state.institutions', 'category.categoryClass'])
            ->orderBy('rank')
            ->paginate(100));

        $categoryClasses = $this->cache('category_classes', 24 * 60 * 60, fn () => CategoryClass::all());

        $rank = $institutions->isNotEmpty() ? $this->computeRankings($institutions) : null;

        $SEOData = $this->seo(
            title: "{$categoryClass->name_plural} Rankings in {$region->name}, Nigeria",
            description: "Discover the top-ranked {$categoryClass->name_plural} in {$region->name}, Nigeria. Compare rankings and find the best {$categoryClass->name_plural} in the region.",
        );

        $shareLinks = $this->shareLinks();

        return view('institution.ranking', compact('institutions', 'rank', 'categoryClass', 'categoryClasses', 'region', 'SEOData', 'shareLinks'));
    }

    private function computeRankings($institutions)
    {
        $rank = [];
        foreach ($institutions as $institution) {
            $computedRank = $this->computeRank($institution, $institutions);
            $rank[$institution->id] = [
                'institution' => $computedRank['institution'],
                'region' => $computedRank['region'],
                'state' => $computedRank['state'],
            ];
        }

        return $rank;
    }

    private function computeRank($institution, $allInstitutions)
    {
        $rank = ['institution' => 0, 'region' => 0, 'state' => 0];

        if ($institution->rank) {
            foreach ($allInstitutions as $school) {
                $rank['institution']++;
                if ($school->id == $institution->id) {
                    break;
                }
            }

            $regionInstitutions = $institution->state->region->institutions
                ->whereNotNull('rank')
                ->where('category_id', $institution->category->id)
                ->sortBy('rank');

            foreach ($regionInstitutions as $regionInstitution) {
                $rank['region']++;
                if ($regionInstitution->id == $institution->id) {
                    break;
                }
            }

            $stateInstitutions = $institution->state->institutions
                ->whereNotNull('rank')
                ->where('category_id', $institution->category->id)
                ->sortBy('rank');

            foreach ($stateInstitutions as $stateInstitution) {
                $rank['state']++;
                if ($stateInstitution->id == $institution->id) {
                    break;
                }
            }
        } else {
            $rank = ['institution' => false, 'region' => false, 'state' => false];
        }

        return $rank;
    }

    public function show(Institution $institution)
    {
        $institution = $this->cache("institution_{$institution->id}", 60 * 60 * 24, function () use ($institution) {
            $institution->load([
                'institutionType', 'category.institutions', 'term', 'catchments',
                'state.institutions', 'state.region.institutions', 'religiousAffiliation', 'institutionHead', 'accreditationBody', 'accreditationStatus', 'parentInstitution', 'childInstitutions', 'affiliatedInstitutions', 'phoneNumbers', 'socials.socialType',
                'levels.programs' => fn ($query) => $query->wherePivot('institution_id', $institution->id),
            ]);

            return $institution;
        });

        $allInstitutions = $this->cache("all_institutions_rank_{$institution->category->id}", 60 * 60 * 24, fn () => Institution::whereNotNull('rank')
            ->where('category_id', $institution->category->id)
            ->orderBy('rank')
            ->get());

        $rank = $this->cache("institution_rank_{$institution->id}", 60 * 60 * 24, fn () => $this->computeRank($institution, $allInstitutions));

        $levels = $institution->levels->unique();

        $SEOData = $this->seo(
            title: "{$institution->name}".($institution->locality ? ", {$institution->locality}" : ''),
            description: "Discover {$institution->name}".($institution->locality ? ", {$institution->locality}" : '').' with detailed information on its academic offerings, including highlights, overview, course programs, tuition fees, ranking, and more.',
        );

        $institution['description_alt'] = "Discover {$institution->name}".($institution->locality ? ", {$institution->locality}" : '').' with detailed information on its academic offerings, including highlights, overview, course programs, tuition fees, ranking, and more.';

        $shareLinks = $this->shareLinks();

        return view('institution.show', compact('institution', 'rank', 'levels', 'SEOData', 'shareLinks'));
    }

    public function programs(Institution $institution, Level $level)
    {
        if ($level->id == 3) {
            $programs = $this->cache("institution_{$institution->id}_level_{$level->id}_programs", 60 * 60, fn () => $institution->programs()
                ->wherePivot('level_id', $level->id)
                ->with('college')
                ->get()
                ->sortBy('name'));
        } else {
            $programs = $this->cache("institution_{$institution->id}_level_{$level->id}_programs", 60 * 60, fn () => $institution->programs()
                ->wherePivot('level_id', $level->id)
                ->with('college')
                ->get()
                ->groupBy(fn ($program) => $program->college->name)
                ->sortKeys()
                ->map(fn ($group) => $group->sortBy(fn ($program) => $program->name)));
        }

        $program_levels = $this->cache("institution_{$institution->id}_unique_program_levels", 60 * 60, fn () => $institution->levels->unique());

        $SEOData = $this->seo(
            title: "{$institution->name}".($institution->locality ? ", {$institution->locality}" : '')." {$level->name} Programmes",
            description: "Explore {$level->name} programs offered at {$institution->name}".($institution->locality ? ", {$institution->locality}" : '').'. Compare and choose the best program for your academic journey.',
        );

        $shareLinks = $this->shareLinks();

        return view('institution.programs', compact('institution', 'level', 'programs', 'program_levels', 'SEOData', 'shareLinks'));
    }

    public function showProgram(Institution $institution, Level $level, Program $program)
    {
        $institution_program = $this->cache("institution_{$institution->id}_program_{$program->id}_level_{$level->id}_show", 60 * 60, fn () => $institution->programs()
            ->where('program_id', $program->id)
            ->wherePivot('level_id', $level->id)
            ->first());

        if (! $institution_program) {
            abort(404);
        }

        $program_levels = $this->cache("institution_{$institution->id}_program_{$program->id}_levels", 60 * 60, fn () => $institution->levels()
            ->wherePivot('program_id', $program->id)
            ->get());

        $SEOData = $this->seo(
            title: "{$program->name} - {$institution->name}".($institution->locality ? ", {$institution->locality}" : ''),
            description: "Detailed information about {$level->name} in {$program->name} offered at {$institution->name}".($institution->locality ? ", {$institution->locality}" : '').'. Program highlights and overview',
        );

        $shareLinks = $this->shareLinks();

        return view('institution.show-program', compact('institution', 'program', 'institution_program', 'level', 'program_levels', 'SEOData', 'shareLinks'));
    }

    public function programLevels(Institution $institution, Program $program)
    {
        $levels = $this->cache("list_institution_{$institution->id}_program_{$program->id}_programLevels", 60 * 60, function () use ($institution, $program) {
            $institution->load([
                'state',
                'levels' => fn ($query) => $query->wherePivot('program_id', $program->id)
                    ->with(['programs' => fn ($query) => $query->wherePivot('institution_id', $institution->id)]),
            ]);

            return $institution->levels;
        });

        $SEOData = $this->seo(
            title: "{$program->name} Study Levels at {$institution->name}".($institution->locality ? ", {$institution->locality}" : ''),
            description: "Explore the available study levels for {$program->name} offered at {$institution->name}.".($institution->locality ? ", {$institution->locality}" : ''),
        );

        $shareLinks = $this->shareLinks();

        return view('institution.program-levels', compact('institution', 'program', 'levels', 'SEOData', 'shareLinks'));
    }
}
