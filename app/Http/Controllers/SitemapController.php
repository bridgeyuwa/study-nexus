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
            $sitemap->add(Url::create("/{$level->slug}/programs")->setLastModificationDate(Carbon::yesterday()));

            foreach ($level->__programs()->get() as $program) {
                $sitemap->add(Url::create("/{$level->slug}/programs/{$program->id}")->setLastModificationDate(Carbon::yesterday()));
                $sitemap->add(Url::create("/{$level->slug}/programs/{$program->id}/institutions")->setLastModificationDate(Carbon::yesterday()));
            }
        }

        // Institutions
        $sitemap->add(Url::create('/institutions')->setLastModificationDate(Carbon::yesterday()));

        // Institutions by category
        foreach ($categoryClasses as $categoryClass) {
            $sitemap->add(Url::create("/institutions/category/{$categoryClass->slug}")->setLastModificationDate(Carbon::yesterday()));
            $sitemap->add(Url::create("/institutions/category/{$categoryClass->slug}/location")->setLastModificationDate(Carbon::yesterday()));
            $sitemap->add(Url::create("/institutions/category/{$categoryClass->slug}/ranking")->setLastModificationDate(Carbon::yesterday()));

            foreach ($regions as $region) {
                $sitemap->add(Url::create("/institutions/category/{$categoryClass->slug}/ranking/region/{$region->slug}")->setLastModificationDate(Carbon::yesterday()));
            }

            foreach ($states as $state) {
                $sitemap->add(Url::create("/institutions/category/{$categoryClass->slug}/location/{$state->slug}")->setLastModificationDate(Carbon::yesterday()));
                $sitemap->add(Url::create("/institutions/category/{$categoryClass->slug}/ranking/state/{$state->slug}")->setLastModificationDate(Carbon::yesterday()));
            }
        }

        $sitemap->add(Url::create('/institutions/location')->setLastModificationDate(Carbon::yesterday()));

        foreach ($states as $state) {
            $sitemap->add(Url::create("/institutions/location/{$state->slug}")->setLastModificationDate(Carbon::yesterday()));
        }

        $sitemap->add(Url::create('/institutions/catchments/policy')->setLastModificationDate(Carbon::yesterday()));

        foreach ($institutions as $institution) {
            $sitemap->add(Url::create("/institutions/{$institution->id}")->setLastModificationDate(Carbon::yesterday()));

            foreach ($levels as $level) {
                foreach ($institution->programs()->wherePivot('level_id', $level->id)->with('college')->get() as $program) {
                    $sitemap->add(Url::create("/institutions/{$institution->id}/levels/{$level->slug}/programs")->setLastModificationDate(Carbon::yesterday()));
                    $sitemap->add(Url::create("/institutions/{$institution->id}/levels/{$level->slug}/programs/{$program->id}")->setLastModificationDate(Carbon::yesterday()));
                    $sitemap->add(Url::create("/institutions/{$institution->id}/programs/{$program->id}")->setLastModificationDate(Carbon::yesterday()));
                }
            }
        }

        // Institutions catchments
        $sitemap->add(Url::create('/institutions/catchments')->setLastModificationDate(Carbon::yesterday()));

        foreach ($catchments as $catchment) {
            $sitemap->add(Url::create("/institutions/catchments/{$catchment->slug}")->setLastModificationDate(Carbon::yesterday()));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response()->json(['message' => 'Sitemap generated successfully.']);
    }
}
