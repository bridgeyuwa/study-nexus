<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Syllabus;
use App\Models\ExamBody;
use App\Models\Subject;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Facades\Cache;

class SyllabusController extends Controller
{
    public function index()
    {
        // Cache the exam bodies for 60 minutes
        $examBodies = Cache::remember('exam_bodies_index', 60 * 60, function () {
            return ExamBody::whereHas('syllabi')->get();
        });
		
		$SEOData = new SEOData(
            title: "Exam Syllabi",
            description: "Explore syllabi for various exams like WAEC, NECO, and more.",
        );
        
        return view('syllabus.index', compact('examBodies','SEOData'));  
    }
    
    public function syllabi(ExamBody $examBody)
    {
        // Cache the syllabi and related subjects for the specific exam body
        $syllabi = Cache::remember("syllabi_exam_body_{$examBody->id}", 60 * 60, function () use ($examBody) {
            return $examBody->syllabi()->orderBy('name')->with(['subject'])->get();
        });
		
		$SEOData = new SEOData(
            title: "{$examBody->abbr} Syllabus",
            description: "Browse the latest syllabus for {$examBody->abbr} exams.",
        );
		
		$shareLinks = \Share::currentPage()
				->facebook()
				->twitter()
				->linkedin()
				->reddit()
				->whatsapp()
				->telegram()
				->getRawLinks();

        return view('syllabus.syllabus', compact('examBody', 'syllabi','SEOData', 'shareLinks'));  
    }
    
    public function show(ExamBody $examBody, Syllabus $syllabus)
    {
        if ($syllabus->exam_body_id !== $examBody->id) {
            abort(404);
        }
		
		$SEOData = new SEOData(
            title: "{$syllabus->subject->name} Syllabus - {$examBody->abbr}",
            description: "Official syllabus for {$syllabus->subject->name} - {$examBody->abbr}.",
        );
		
		$shareLinks = \Share::currentPage()
				->facebook()
				->twitter()
				->linkedin()
				->reddit()
				->whatsapp()
				->telegram()
				->getRawLinks();

        return view('syllabus.show', compact('examBody', 'syllabus','SEOData', 'shareLinks'));     
    }
}
