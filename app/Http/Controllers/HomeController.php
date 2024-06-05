<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\College;
use App\Models\Institution;
use App\Models\Program;
use App\Models\Region;

class HomeController extends Controller {

    public function index() {

        $states = State::all();
        $colleges = College::all();
        $institutions = Institution::all();
        $programs = Program::all();
        $regions = Region::all();
        
        
        $rankedInstitutions = Institution::whereNotNull('rank')->orderBy('rank')->limit(6)->get();
        $randomPrograms = Program::inRandomOrder()->limit(6)->get();
        $randomStates = State::inRandomOrder()->limit(6)->get();
        
       return view('home', compact('states','regions', 'colleges','institutions','programs','rankedInstitutions','randomStates','randomPrograms'));
    }

}
