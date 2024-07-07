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
							   
$jsonLd = Schema::organization()
    ->name('StudyNexus')
    ->url(url('/'))
    ->description('Discover universities, polytechnics, monotechnics, and colleges of education in Nigeria. Explore the online directory academic course programs, rankings, and more on Study Nexus.')
    ->address(Schema::postalAddress()->addressLocality('Nigeria'))
    ->sameAs([
        'https://facebook.com/studynexus_ng',
        'https://x.com/studynexus_ng',
        'http://instagram.com/studynexus_ng',
        'http://linkedin.com/studynexus_ng',
        'http://tiktok.com/studynexus_ng',
        'http://youtube.com/studynexus_ng',
    ])
    ->logo(url('/logo.png'))
    ->contactPoint(Schema::contactPoint()
        ->contactType('customer service')
        ->telephone('+234-902-100-4028')
        ->email('contact@example.com')
    )
    
    ->service(Schema::service()
        ->name('University Search')
        ->description('Search and compare universities, polytechnics and colleges of education in the Nigeria.')
    )
    ->service(Schema::service()
        ->name('Scholarship Information')
        ->description('Access information about scholarships available for Nigerian students.')
    )
    ->service(Schema::service()
        ->name('Career Counseling')
        ->description('Get guidance on career paths and opportunities after graduation.')
    )
    ->service(Schema::service()
        ->name('Study Abroad')
        ->description('Explore opportunities to study abroad for Nigerian students.')
    );


       return view('home', compact('institutions','programs','categories','levels','SEOData','jsonLd'));
    }

}
