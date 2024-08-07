<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Institution;
use App\Models\Program;
use App\Models\Catchment;
use App\Models\CategoryClass;
use App\Models\Level;
use App\Models\State;
use App\Models\Region;
use Carbon\Carbon;
class SitemapController extends Controller
{
    public function index()
    {
        $institutions = Institution::with('programs')->get();
        $categoryClasses = CategoryClass::all();
        $states = State::all();
        $regions = Region::all();
        $levels = Level::with('__programs')->get();
		$catchments = Catchment::all();

        $sitemap = Sitemap::create()

		
            // Static URLs
            ->add(Url::create(route('home'))->setLastModificationDate(Carbon::yesterday()))
            ->add(Url::create(route('search'))->setLastModificationDate(Carbon::yesterday()))
            ->add(Url::create(route('about'))->setLastModificationDate(Carbon::yesterday()))
            ->add(Url::create(route('tos'))->setLastModificationDate(Carbon::yesterday()))
            ->add(Url::create(route('policy'))->setLastModificationDate(Carbon::yesterday()))
            ->add(Url::create(route('contact'))->setLastModificationDate(Carbon::yesterday()));

        // Programs by Level
        foreach ($levels as $level) {
            $sitemap->add(Url::create(route('programs.index', ['level' => $level]))->setLastModificationDate(Carbon::yesterday()));

            foreach ($level->__programs()->get() as $program) {
                $sitemap->add(Url::create(route('programs.show', ['level' => $level, 'program' => $program]))->setLastModificationDate(Carbon::yesterday()));
                $sitemap->add(Url::create(route('programs.institutions', ['level' => $level, 'program' => $program]))->setLastModificationDate(Carbon::yesterday()));
            }
        }

        // Institutions
        $sitemap->add(Url::create(route('institutions.index'))->setLastModificationDate(Carbon::yesterday()));

        // Institutions by category
        foreach ($categoryClasses as $categoryClass) {
            $sitemap->add(Url::create(route('institutions.categories.index', ['categoryClass' => $categoryClass]))->setLastModificationDate(Carbon::yesterday()));
            $sitemap->add(Url::create(route('institutions.categories.location', ['categoryClass' => $categoryClass]))->setLastModificationDate(Carbon::yesterday()));
            $sitemap->add(Url::create(route('institutions.categories.ranking', ['categoryClass' => $categoryClass]))->setLastModificationDate(Carbon::yesterday()));

            foreach ($regions as $region) {
                $sitemap->add(Url::create(route('institutions.categories.ranking.region', ['categoryClass' => $categoryClass, 'region' => $region]))->setLastModificationDate(Carbon::yesterday()));
            }

            foreach ($states as $state) {
                $sitemap->add(Url::create(route('institutions.categories.location.show', ['categoryClass' => $categoryClass, 'state' => $state]))->setLastModificationDate(Carbon::yesterday()));
                $sitemap->add(Url::create(route('institutions.categories.ranking.state', ['categoryClass' => $categoryClass, 'state' => $state]))->setLastModificationDate(Carbon::yesterday()));
            }
        }

        $sitemap->add(Url::create(route('institutions.location'))->setLastModificationDate(Carbon::yesterday()));

        foreach ($states as $state) {
            $sitemap->add(Url::create(route('institutions.location.show', ['state' => $state]))->setLastModificationDate(Carbon::yesterday()));
        }

        $sitemap->add(Url::create(route('institutions.catchments.policy'))->setLastModificationDate(Carbon::yesterday()));

        foreach ($institutions as $institution) {
            $sitemap->add(Url::create(route('institutions.show', ['institution' => $institution]))->setLastModificationDate(Carbon::yesterday()));

            foreach ($levels as $level) {
                foreach ($institution->programs()->wherePivot('level_id', $level->id)->with('college')->get() as $program) {
                    $sitemap->add(Url::create(route('institutions.programs', ['institution' => $institution, 'level' => $level]))->setLastModificationDate(Carbon::yesterday()));
                    $sitemap->add(Url::create(route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $program]))->setLastModificationDate(Carbon::yesterday()));
                    $sitemap->add(Url::create(route('institutions.program.levels', ['institution' => $institution, 'program' => $program]))->setLastModificationDate(Carbon::yesterday()));
                }
            }
        }

        // Institutions catchments
        $sitemap->add(Url::create(route('institutions.catchments.index'))->setLastModificationDate(Carbon::yesterday()));

        foreach ($catchments as $catchment) {
            $sitemap->add(Url::create(route('institutions.catchments.show', ['catchment' => $catchment]))->setLastModificationDate(Carbon::yesterday()));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response()->json(['message' => 'Sitemap generated successfully.']);
    }
}
