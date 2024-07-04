<?php

namespace App\Http\Controllers;
use App\Models\Level;
/* create levels pages */






class LevelController extends Controller
{
    public function index() {
       
        $levels = Level::all();
        
        return view('Level.index', compact('levels'));
    }
    
    public function show(Level $Level) {
        
       return view('Level.show', compact('Level'));
    }
    
    
    
    
}
