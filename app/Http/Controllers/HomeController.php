<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Program;
use App\Models\Category;
use App\Models\Level;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\SchemaOrg\Schema;

class HomeController extends Controller {

    public function index() {

        $institutions = Institution::all();
        $programs = Program::all();
		$categories = Category::all();
		$levels = Level::all(); 
        
        $SEOData = new SEOData( 
                           description: 'Discover universities, polytechnics, monotechnics, and colleges of education in Nigeria. Explore the online directory academic course programs, rankings, and more on Study Nexus.',
                               );
							   
	$website = Schema::website()
               ->url('/')
               ->name('StudyNexus')	
               ->description('Discover universities, polytechnics, monotechnics, and colleges of education in Nigeria. Explore the online directory academic course programs, rankings, and more on Study Nexus.')	
               ->publisher(
                           Schema::organization()
                               ->name('StudyNexus')
                               ->url('http://studynexus.ng')
                               ->logo('')
                               ->sameAs(['https://facebook.com/studynexus_ng','https://x.com/studynexus_ng'])
                            );	
 
          $service1 = Schema::service()
                   ->name('StudyNexus')
                   ->url('http://studynexus.ng')
                   ->logo('')
                   ->serviceType('Educational Directory')
                   ->description('');	

         $service2 = Schema::service()
                   ->name('StudyNexus')
                   ->url('http://studynexus.ng')
                   ->logo('')
                   ->serviceType('')
                   ->description();

		   
							     

       return view('home', compact('institutions','programs','categories','levels','SEOData','jsonLd'));
    }

}
