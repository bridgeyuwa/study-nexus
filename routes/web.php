<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CatchmentController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\SyllabusController;
use App\Livewire\ContactForm;

/* Home */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* Search institutions / Programs and filter */
Route::get('/search', [SearchController::class, 'index'])->name('search');


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
    return view('contact');
})->name('contact');


/* Programs by Level */
Route::prefix('{level}/programs')->name('programs.')->group(function () {
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
    Route::get('location/{state}', [InstitutionController::class, 'showLocation'])->name('location.show');

    /* All Institutions Catchments */
    Route::prefix('catchments')->name('catchments.')->group(function () {
        Route::get('/', [CatchmentController::class, 'index'])->name('index');
        Route::get('policy', [CatchmentController::class, 'policy'])->name('policy');
        Route::get('{catchment}', [CatchmentController::class, 'show'])->name('show');
    });

    /* Institutions Categories */
    Route::prefix('category/{categoryClass}')->name('categories.')->group(function () {
        Route::get('/', [InstitutionController::class, 'category'])->name('index');
        Route::get('location', [InstitutionController::class, 'categoryLocation'])->name('location');
        Route::get('location/{state}', [InstitutionController::class, 'showCategoryLocation'])->name('location.show');
        
        /* Institutions Ranking */
        Route::get('ranking', [InstitutionController::class, 'institutionRanking'])->name('ranking');
        /* State Ranking */
        Route::get('ranking/state/{state}', [InstitutionController::class, 'stateRanking'])->name('ranking.state');
        /* Region Ranking */
        Route::get('ranking/region/{region}', [InstitutionController::class, 'regionRanking'])->name('ranking.region');
    });

    /* Institutions Show (show an institution) */
    Route::get('{institution}', [InstitutionController::class, 'show'])->name('show');

    /* List institution programs of a particular study level */
    Route::get('{institution}/levels/{level}/programs', [InstitutionController::class, 'programs'])->name('programs');

    /* Show an institution program of a particular level */
    Route::get('{institution}/levels/{level}/programs/{program}', [InstitutionController::class, 'showProgram'])->name('program.show');

    /* show available Levels of an institution program */
    Route::get('{institution}/programs/{program}', [InstitutionController::class, 'programLevels'])->name('program.levels');

	/* list of news of an institution*/
	Route::get('{institution}/news', [NewsController::class, 'indexByInstitution'])->name('news');
    
	/* show a news of an institution*/
	Route::get('{institution}/news/{news}', [NewsController::class, 'showByInstitution'])->name('news.show');
    

});

Route::prefix('news')->name('news.')->group(function () {
    /* list of all news */
    Route::get('/', [NewsController::class, 'index'])->name('index');
	
	/* show news */
    Route::get('/{news}', [NewsController::class, 'show'])->name('show');
	
	
    
    /* list of news of a news category */
    Route::get('/newscategory/{newsCategory}', [NewsController::class, 'indexByNewsCategory'])->name('newsCategory');
    
	/* show news of a news category */
    Route::get('/newscategory/{newsCategory}/{news}', [NewsController::class, 'showByNewsCategory'])->name('newsCategory.show');
    
   
});


Route::get('/forum', function () {
    return redirect('/forum/index.php');
})->name('forum');



/* Timetable */

   Route::prefix('timetables')->name('timetable.')->group(function () {
    /* list of all timetable */
    Route::get('/', [TimetableController::class, 'index'])->name('index');
	
	/* show news */
    Route::get('{exam}', [TimetableController::class, 'show'])->name('show');
	
});


/* Syllabus */
	Route::prefix('syllabuses')->name('syllabus.')->group(function () {
		/* list of all Exam Bodies */
		Route::get('/', [SyllabusController::class, 'index'])->name('index');
		
		Route::get('{examBody}', [SyllabusController::class, 'subjects'])->name('subjects');
		
		/* show subject syllabus of an Exam body */
		Route::get('{examBody}/{syllabus}', [SyllabusController::class, 'show'])->name('show');
		
	});