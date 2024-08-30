<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamBody;
use App\Models\Exam;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Cache;

class TimetableController extends Controller
{     
    /**
     * Display a listing of the Exams Timetables.
     */
    public function index()
    {
        // Cache the exam bodies with their exams for 60 minutes
        $examBodies = Cache::remember('exam_bodies_with_exams', 60, function () {
            return ExamBody::with(['exams'])->get();
        });
		
		$SEOData = new SEOData(
            title: "Exams Timetables",
            description: "Find the latest timetables for all major exams like WAEC, NECO, and NABTEB.",
        );

        return view('timetable.index', compact('examBodies','SEOData'));  
    }

    /**
     * Display a Timetable.
     */
    public function show(Exam $exam)
    {
        // Cache the timetables grouped by exam date for 60 minutes
        $groupedTimetables = Cache::remember("timetables_grouped_by_exam_date_{$exam->id}", 60, function () use ($exam) {
            return $exam->timetables()->get()->groupBy('exam_date');
        });
		
		$SEOData = new SEOData(
            title: "{$exam->name} Timetable",
            description: "View the full timetable for {$exam->name}, including exam dates and subjects.",
        );

        return view('timetable.show', compact('exam', 'groupedTimetables','SEOData'));     
    }
}
