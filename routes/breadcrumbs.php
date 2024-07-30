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
    $trail->push($level->name . ' Programmes', route('programs.index', $level));
});

Breadcrumbs::for('programs.show', function (BreadcrumbTrail $trail, $level, $program) {
    $trail->parent('programs.index', $level);
    $trail->push($program->name, route('programs.show', [$level, $program]));
});

Breadcrumbs::for('programs.institutions', function (BreadcrumbTrail $trail, $level, $program) {
    $trail->parent('programs.show', $level, $program);
    $trail->push('Institutions', route('programs.institutions', [$level, $program]));
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
    $trail->push($state->name . ($state->is_state ? ' State' : ''), route('institutions.location.show', $state));
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
    $trail->push($catchment->name, route('institutions.catchments.show', $catchment));
});

// Institutions Categories
Breadcrumbs::for('institutions.categories.index', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('institutions.index');
    $trail->push($category->name_plural, route('institutions.categories.index', $category));
});

Breadcrumbs::for('institutions.categories.location', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('institutions.categories.index', $category);
    $trail->push('Locations', route('institutions.categories.location', $category));
});

Breadcrumbs::for('institutions.categories.location.show', function (BreadcrumbTrail $trail, $category, $state) {
    $trail->parent('institutions.categories.location', $category);
$trail->push($state->name . ($state->is_state ? ' State' : ''), route('institutions.categories.location.show', [$category, $state]));
});

// Institutions Ranking
Breadcrumbs::for('institutions.categories.ranking', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('institutions.categories.index', $category);
    $trail->push('Rankings', route('institutions.categories.ranking', $category));
});

Breadcrumbs::for('institutions.categories.ranking.state', function (BreadcrumbTrail $trail, $category, $state) {
    $trail->parent('institutions.categories.ranking', $category);
    $trail->push($state->name, route('institutions.categories.ranking.state', [$category, $state]));
});

Breadcrumbs::for('institutions.categories.ranking.region', function (BreadcrumbTrail $trail, $category, $region) {
    $trail->parent('institutions.categories.ranking', $category);
    $trail->push($region->name, route('institutions.categories.ranking.region', [$category, $region]));
});

// Institutions Show
Breadcrumbs::for('institutions.show', function (BreadcrumbTrail $trail, $institution) {
    $trail->parent('institutions.index');
    $trail->push($institution->name, route('institutions.show', $institution));
});

// List institution programs of a particular study level
Breadcrumbs::for('institutions.programs', function (BreadcrumbTrail $trail, $institution, $level) {
    $trail->parent('institutions.show', $institution);
    $trail->push($level->name . ' Programmes', route('institutions.programs', [$institution, $level]));
});

// Show an institution program of a particular level
Breadcrumbs::for('institutions.program.show', function (BreadcrumbTrail $trail, $institution, $level, $program) {
    $trail->parent('institutions.programs', $institution, $level);
    $trail->push($program->name, route('institutions.program.show', [$institution, $level, $program]));
});

// Show available Levels of an institution program
Breadcrumbs::for('institutions.program.levels', function (BreadcrumbTrail $trail, $institution, $program) {
    $trail->parent('institutions.show', $institution);
    $trail->push($program->name, route('institutions.program.levels', [$institution, $program]));
});
