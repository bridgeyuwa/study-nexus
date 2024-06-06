<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CatchmentController;

Route::get('/welcome', function () {
    return view('welcome');
});



/* Home */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* Search institutions / Programs and filter */
Route::get('search', [SearchController::class, 'index'])->name('search');



Route::get('/about', function () {

$aboutFile = resource_path('markdown/about.md');
    return view('about',['about' => Str::markdown(file_get_contents($aboutFile)),]);
})->name('about');


Route::get('/terms-of-service', function () {

    $termsFile = resource_path('markdown/terms.md');
    return view('terms',['terms' => Str::markdown(file_get_contents($termsFile)),]);
})->name('tos');

Route::get('/privacy-policy', function () {

     $policyFile = resource_path('markdown/policy.md');
    return view('policy', ['policy' => Str::markdown(file_get_contents($policyFile)),]);
})->name('policy');



Route::get('/contact', function () {
    return view('welcome');
})->name('contact');



/* Programs by Level */
Route::prefix('{level:slug}/programs')->name('programs.')->group(function () {
    /* list Programs of a Level */
    Route::get('/', [ProgramController::class, 'index'])->name('index');
    
    /* Show a Program of a Level */
    Route::get('{program}', [ProgramController::class, 'show'])->name('show');
    
    /* List Institutions that offer a Program of a Level */
    Route::get('{program}/institutions', [ProgramController::class, 'institutions'])->name('institutions');
});

/* Institutions */
Route::prefix('institutions')->name('institutions.')->group(function () {
    /* list all institutions */
    Route::get('/', [InstitutionController::class, 'index'])->name('index');
    Route::get('location', [InstitutionController::class, 'location'])->name('location');
    Route::get('location/{state:slug}', [InstitutionController::class, 'showLocation'])->name('location.show');

    /* All Institutions Catchments */
    Route::prefix('catchments')->name('catchments.')->group(function () {
        Route::get('/', [CatchmentController::class, 'index'])->name('index');
        Route::get('policy', [CatchmentController::class, 'policy'])->name('policy');
        Route::get('{catchment:slug}', [CatchmentController::class, 'show'])->name('show');
    });

    /* Institutions Categories */
    Route::prefix('category/{category:slug}')->name('categories.')->group(function () {
        Route::get('/', [InstitutionController::class, 'category'])->name('index');
        Route::get('location', [InstitutionController::class, 'categoryLocation'])->name('location');
        Route::get('location/{state:slug}', [InstitutionController::class, 'showCategoryLocation'])->withoutScopedBindings()->name('location.show');
        
        /* Institutions Ranking */
        Route::get('ranking', [InstitutionController::class, 'institutionRanking'])->name('ranking');
        /* State Ranking */
        Route::get('ranking/state/{state:slug}', [InstitutionController::class, 'stateRanking'])->withoutScopedBindings()->name('ranking.state');
        /* Region Ranking */
        Route::get('ranking/region/{region:slug}', [InstitutionController::class, 'regionRanking'])->withoutScopedBindings()->name('ranking.region');
    });

    /* Institutions Show (show an institution) */
    Route::get('{institution}', [InstitutionController::class, 'show'])->name('show');

    /* List institution programs of a particular study level */
    Route::get('{institution}/levels/{level:slug}/programs', [InstitutionController::class, 'programs'])->name('programs');

    /* Show an institution program of a particular level */
    Route::get('{institution}/levels/{level:slug}/programs/{program}', [InstitutionController::class, 'program'])->name('program');

    /* show available Levels of an institution program */
    Route::get('{institution}/programs/{program}', [InstitutionController::class, 'programLevels'])->name('program.levels');
});
