<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\ExamBody;
use App\Models\Subject;
use Illuminate\Support\Facades\Cache;

class SyllabusController extends Controller
{
    public function index()
    {
        // Cache the exam bodies for 60 minutes
        $examBodies = Cache::remember('exam_bodies_index', 60, function () {
            return ExamBody::all();
        });
        
        return view('syllabus.index', compact('examBodies'));  
    }
    
    public function syllabi(ExamBody $examBody)
    {
        // Cache the syllabi and related subjects for the specific exam body
        $syllabi = Cache::remember("syllabi_exam_body_{$examBody->id}", 60, function () use ($examBody) {
            return $examBody->syllabi()->with(['subject'])->get();
        });

        return view('syllabus.syllabus', compact('examBody', 'syllabi'));  
    }
    
    public function show(ExamBody $examBody, Syllabus $syllabus)
    {
        if ($syllabus->exam_body_id !== $examBody->id) {
            abort(404);
        }

        return view('syllabus.show', compact('examBody', 'syllabus'));     
    }
}
