<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Search
Breadcrumbs::for('search', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Search', route('search'));
});

// About
Breadcrumbs::for('about', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('About', route('about'));
});

// Terms of Service
Breadcrumbs::for('tos', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Terms of Service', route('tos'));
});

// Privacy Policy
Breadcrumbs::for('policy', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Privacy Policy', route('policy'));
});

// Contact
Breadcrumbs::for('contact', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Contact', route('contact'));
});

// Programs by Level
Breadcrumbs::for('programs.index', function (BreadcrumbTrail $trail, $level) {
    $trail->parent('home');
    $trail->push($level->name . ' Programmes', route('programs.index', ['level' => $level]));
});

Breadcrumbs::for('programs.show', function (BreadcrumbTrail $trail, $level, $program) {
    $trail->parent('programs.index', $level);
    $trail->push($program->name, route('programs.show', ['level' => $level, 'program' => $program]));
});

Breadcrumbs::for('programs.institutions', function (BreadcrumbTrail $trail, $level, $program) {
    $trail->parent('programs.show', $level, $program);
    $trail->push('Institutions', route('programs.institutions', ['level' => $level, 'program' => $program]));
});

// Institutions
Breadcrumbs::for('institutions.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Institutions', route('institutions.index'));
});

Breadcrumbs::for('institutions.location', function (BreadcrumbTrail $trail) {
    $trail->parent('institutions.index');
    $trail->push('Locations', route('institutions.location'));
});

Breadcrumbs::for('institutions.location.show', function (BreadcrumbTrail $trail, $state) {
    $trail->parent('institutions.location');
    $trail->push($state->name . ($state->is_state ? ' State' : ''), route('institutions.location.show', ['state' => $state]));
});

// Institutions Catchments
Breadcrumbs::for('institutions.catchments.index', function (BreadcrumbTrail $trail) {
    $trail->parent('institutions.index');
    $trail->push('Catchments', route('institutions.catchments.index'));
});

Breadcrumbs::for('institutions.catchments.policy', function (BreadcrumbTrail $trail) {
    $trail->parent('institutions.catchments.index');
    $trail->push('Policy', route('institutions.catchments.policy'));
});

Breadcrumbs::for('institutions.catchments.show', function (BreadcrumbTrail $trail, $catchment) {
    $trail->parent('institutions.catchments.index');
    $trail->push($catchment->name, route('institutions.catchments.show', ['catchment' => $catchment]));
});

// Institutions Categories
Breadcrumbs::for('institutions.categories.index', function (BreadcrumbTrail $trail, $categoryClass) {
    $trail->parent('institutions.index');
    $trail->push($categoryClass->name_plural, route('institutions.categories.index', ['categoryClass' => $categoryClass]));
});

Breadcrumbs::for('institutions.categories.location', function (BreadcrumbTrail $trail, $categoryClass) {
    $trail->parent('institutions.categories.index', $categoryClass);
    $trail->push('Locations', route('institutions.categories.location', ['categoryClass' => $categoryClass]));
});

Breadcrumbs::for('institutions.categories.location.show', function (BreadcrumbTrail $trail, $categoryClass, $state) {
    $trail->parent('institutions.categories.location', $categoryClass);
$trail->push($state->name . ($state->is_state ? ' State' : ''), route('institutions.categories.location.show', ['categoryClass' => $categoryClass, 'state' => $state]));
});

// Institutions Ranking
Breadcrumbs::for('institutions.categories.ranking', function (BreadcrumbTrail $trail, $categoryClass) {
    $trail->parent('institutions.categories.index', $categoryClass);
    $trail->push('Rankings', route('institutions.categories.ranking', ['categoryClass' => $categoryClass]));
});

Breadcrumbs::for('institutions.categories.ranking.state', function (BreadcrumbTrail $trail, $categoryClass, $state) {
    $trail->parent('institutions.categories.ranking', $categoryClass);
    $trail->push($state->name, route('institutions.categories.ranking.state', ['categoryClass' => $categoryClass, 'state' => $state]));
});

Breadcrumbs::for('institutions.categories.ranking.region', function (BreadcrumbTrail $trail, $categoryClass, $region) {
    $trail->parent('institutions.categories.ranking', $categoryClass);
    $trail->push($region->name, route('institutions.categories.ranking.region', ['categoryClass' => $categoryClass, 'region' => $region]));
});

// Institutions Show
Breadcrumbs::for('institutions.show', function (BreadcrumbTrail $trail, $institution) {
    $trail->parent('institutions.index');
    $trail->push($institution->name, route('institutions.show', ['institution' => $institution]));
});

// List institution programs of a particular study level
Breadcrumbs::for('institutions.programs', function (BreadcrumbTrail $trail, $institution, $level) {
    $trail->parent('institutions.show', $institution);
    $trail->push($level->name . ' Programmes', route('institutions.programs', ['institution' => $institution, 'level' => $level]));
});

// Show an institution program of a particular level
Breadcrumbs::for('institutions.program.show', function (BreadcrumbTrail $trail, $institution, $level, $program) {
    $trail->parent('institutions.programs', $institution, $level);
    $trail->push($program->name, route('institutions.program.show', ['institution' => $institution, 'level' => $level, 'program' => $program]));
});

// Show available Levels of an institution program
Breadcrumbs::for('institutions.program.levels', function (BreadcrumbTrail $trail, $institution, $program) {
    $trail->parent('institutions.show', $institution);
    $trail->push($program->name, route('institutions.program.levels', ['institution' => $institution, 'program' => $program]));
});


//News

//List News
Breadcrumbs::for('news.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('News', route('news.index'));
});

//Show news
Breadcrumbs::for('news.show', function (BreadcrumbTrail $trail, $news) {
    $trail->parent('news.index');
    $trail->push($news->title, route('news.show', ['news' => $news]));
});

//List all News Categories
Breadcrumbs::for('news.newsCategories', function (BreadcrumbTrail $trail) {
    $trail->parent('news.index');
    $trail->push('Categories', route('news.newsCategories'));
});


// List News of a Category
Breadcrumbs::for('news.newsCategory', function (BreadcrumbTrail $trail, $newsCategory) {
    $trail->parent('news.newsCategories');
    $trail->push($newsCategory->name, route('news.newsCategory', ['newsCategory' => $newsCategory]));
});

// Show News by Category
Breadcrumbs::for('news.newsCategory.show', function (BreadcrumbTrail $trail, $newsCategory, $news) {
    $trail->parent('news.newsCategory', $newsCategory);
    $trail->push($news->title, route('news.newsCategory.show', ['newsCategory' => $newsCategory, 'news' => $news]));
});

// List News by Institution
Breadcrumbs::for('institutions.news', function (BreadcrumbTrail $trail, $institution) {
    $trail->parent('institutions.show', $institution );
    $trail->push('News', route('institutions.news', ['institution' => $institution]));
});


// Show News by Institution
Breadcrumbs::for('institutions.news.show', function (BreadcrumbTrail $trail, $institution, $news) {
    $trail->parent('institutions.news', $institution);
    $trail->push($news->title, route('institutions.news.show', ['institution' => $institution, 'news' => $news]));
});




// List Exam bodies for Syllabus
Breadcrumbs::for('syllabus.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Syllabus', route('syllabus.index'));
});

// List Exam Syllabi for Exam body
Breadcrumbs::for('syllabus.subjects', function (BreadcrumbTrail $trail, $exam) {
    $trail->parent('syllabus.index');
    $trail->push($exam->abbr, route('syllabus.subjects', ['exam' => $exam]));
});

// Show syllabus for a subject of an exam body
Breadcrumbs::for('syllabus.show', function (BreadcrumbTrail $trail, $exam, $syllabus) {
    $trail->parent('syllabus.subjects', $exam);
    $trail->push($syllabus->name, route('syllabus.show', ['exam' => $exam, 'syllabus' => $syllabus]));
});


//Timetable List
Breadcrumbs::for('timetable.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Timetables', route('timetable.index'));
});

// Show Timetable
Breadcrumbs::for('timetable.show', function (BreadcrumbTrail $trail, $exam) {
    $trail->parent('timetable.index');
    $trail->push($exam->name, route('timetable.show',['exam'=> $exam]));
});

