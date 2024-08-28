<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\ExamBody;
use App\Models\Subject;

class SyllabusController extends Controller
{
    public function index()
    {
        $examBodies = ExamBody::all();
		
		 return view('syllabus.index', compact('examBodies'));  
    }
	
	public function subjects(ExamBody $examBody )
	{
		/* $subjects = Subject::whereHas('syllabi',
		
			function ($query) use ($examBody)
			{
				$query->where('exam_body_id', $examBody->id);
			})->get(); */
			
			$syllabi = $examBody->syllabi()->with(['subject'])->get();
			
			
		return view('syllabus.subjects', compact('examBody','syllabi'));  
	}
	
	public function show(ExamBody $examBody, Syllabus $syllabus)
    {
       
		return view('syllabus.show', compact('examBody','syllabus'));  	
    }
}
