<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;
use App\Models\Program;
use App\Models\Category;
use App\Models\Level;

class HomeController extends Controller {

    public function index() {

        $institutions = Institution::all();
        $programs = Program::all();
		$categories = Category::all();
		$levels = Level::all(); 
        
       return view('home', compact('institutions','programs','categories','levels'));
    }

}
