<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBody;
use App\Models\Exam;

class TimetableController extends Controller
{     
    /**
     * Display a listing of the Exams Timetables.
     */
    public function index()
    {
        
		$examBodies = ExamBody::with(['exams'])->get();
		
		//dd($examBodies);
		
		 return view('timetable.index', compact('examBodies'));  
    }

    /**
     * Display a Timetable.
     */
    public function show(Exam $exam)
    {
        
		$groupedTimetables = $exam->timetables()->get()->groupBy('exam_date');
		
		return view('timetable.show', compact('exam','groupedTimetables'));  	
    }

   
}
