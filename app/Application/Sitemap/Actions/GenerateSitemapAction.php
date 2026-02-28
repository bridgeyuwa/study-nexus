<?php

namespace App\Application\Sitemap\Actions;

use App\Models\Catchment;
use App\Models\CategoryClass;
use App\Models\Exam;
use App\Models\Institution;
use App\Models\Level;
use App\Models\News;
use App\Models\Region;
use App\Models\State;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

final class GenerateSitemapAction
{
    public function execute(): void
    {
        $institutions = Institution::with('programs')->get();
        $categoryClasses = CategoryClass::all();
        $states = State::all();
        $regions = Region::all();
        $levels = Level::with('__programs')->get();
        $catchments = Catchment::all();
        $news = News::all();

        $sitemap = Sitemap::create()
            ->add(Url::create(route('home')))
            ->add(Url::create(route('search')))
            ->add(Url::create(route('about')))
            ->add(Url::create(route('tos')))
            ->add(Url::create(route('policy')))
            ->add(Url::create(route('contact')));

        foreach ($levels as $level) {
            $sitemap->add(Url::create(route('programs.index', ['level' => $level])));

            foreach ($level->__programs()->get() as $program) {
                $sitemap->add(Url::create(route('programs.show', ['level' => $level, 'program' => $program])));
                $sitemap->add(Url::create(route('programs.institutions', ['level' => $level, 'program' => $program])));
            }
        }

        $sitemap->add(Url::create(route('institutions.index')));

        foreach ($categoryClasses as $categoryClass) {
            $sitemap->add(Url::create(route('institutions.categories.index', ['categoryClass' => $categoryClass])));
            $sitemap->add(Url::create(route('institutions.categories.location', ['categoryClass' => $categoryClass])));
            $sitemap->add(Url::create(route('institutions.categories.ranking', ['categoryClass' => $categoryClass])));

            foreach ($regions as $region) {
                $sitemap->add(Url::create(route('institutions.categories.ranking.region', ['categoryClass' => $categoryClass, 'region' => $region])));
            }

            foreach ($states as $state) {
                $sitemap->add(Url::create(route('institutions.categories.location.show', ['categoryClass' => $categoryClass, 'state' => $state])));
                $sitemap->add(Url::create(route('institutions.categories.ranking.state', ['categoryClass' => $categoryClass, 'state' => $state])));
            }
        }

        $sitemap->add(Url::create(route('institutions.location')));

        foreach ($states as $state) {
            $sitemap->add(Url::create(route('institutions.location.show', ['state' => $state])));
        }

        $sitemap->add(Url::create(route('institutions.catchments.policy')));

        foreach ($institutions as $institution) {
            $sitemap->add(Url::create(route('institutions.show', ['institution' => $institution])));

            if ($institution->news()->exists()) {
                $sitemap->add(Url::create(route('institutions.news', ['institution' => $institution])));
            }

            foreach ($levels as $level) {
                $institutionPrograms = $institution->programs()->wherePivot('level_id', $level->id)->get();

                if ($institutionPrograms->isNotEmpty()) {
                    foreach ($institutionPrograms as $institutionProgram) {
                        $sitemap->add(Url::create(route('institutions.programs', ['institution' => $institution, 'level' => $level])));
                        $sitemap->add(Url::create(route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $institutionProgram])));
                    }
                }
            }
        }

        $sitemap->add(Url::create(route('institutions.catchments.index')));

        foreach ($catchments as $catchment) {
            $sitemap->add(Url::create(route('institutions.catchments.show', ['catchment' => $catchment])));
        }

        $sitemap->add(Url::create(route('news.index')));
        $sitemap->add(Url::create(route('news.newsCategories')));

        foreach ($news as $story) {
            $sitemap->add(Url::create(route('news.show', ['news' => $story])));
        }

        $sitemap->add(Url::create(route('timetable.index')));

        foreach (Exam::whereHas('timetables')->get() as $exam) {
            $sitemap->add(Url::create(route('timetable.show', ['exam' => $exam])));
        }

        $sitemap->add(Url::create(route('syllabus.index')));

        foreach (Exam::whereHas('syllabi')->with('syllabi')->get() as $exam) {
            $sitemap->add(Url::create(route('syllabus.subjects', ['exam' => $exam])));

            foreach ($exam->syllabi as $syllabus) {
                $sitemap->add(Url::create(route('syllabus.show', ['exam' => $exam, 'syllabus' => $syllabus])));
            }
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
