<?php

namespace App\Http\Controllers;
use App\Models\State;
use App\Models\College;

use Illuminate\Http\Request;

class CollegeController extends Controller
{
    public function index() {

        $states = State::all();
        $colleges = College::all();
        
        return view('college.index', compact('states', 'colleges'));
    }
    
    public function show($id) {
        
        $college = College::find($id);

        return view('college.show', compact('college'));
    }
}
