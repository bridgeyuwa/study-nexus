<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\ExamBody;

class SyllabusController extends Controller
{
    public function index()
    {
        examBodies = ExamBody::all();
		
		 return view('syllabus.index', compact('examBodies'));  
    }
	
	public function subjects(ExamBody $examBody )
	{
		$subjects = $examBody->subjects;
		
		return view('syllabus.subjects', compact('subjects'));  
	}
	
	public function show(Syllabus $syllabus)
    {
        
		
		return view('syllabus.show', compact('syllabus'));  	
    }
}
