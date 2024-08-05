<?php

namespace App\Http\Controllers;
use App\Models\Program;
use App\Models\Level;
use RalphJSmit\Laravel\SEO\Support\SEOData;




class ProgramController extends Controller
{
    /* list programs at a particular Level of study */

    public function index(Level $level) {
		//eager load programs for tuition computation
		$level->load('programs');
    
		$program_levels = Level::all();

		// Get the programs with the college relationship eager loaded

		$programs = $level->__programs()->with('college')->get()
			->groupBy(function ($program) {
				return $program->college->name;
			})
			->sortKeys()
			->map(function ($group) {
                return $group->sortBy(fn($program) => $program->name);  // Sort the programs within each college by name
            });
			
		$SEOData = new SEOData(
			title: "{$level->name} Course Programs in Nigeria",
			description: "Discover {$level->name} programs across academic institutions in Nigeria. Compare and choose the best course program for your academic journey.",
		);
									   
		return view('program.index', compact('programs','level','program_levels','SEOData'));
	}





    /* show a program of a level of study */

	public function show( Level $level, Program $program) {

		//eager load programs on level for tuition fee range computation
		$level->load([ 'programs' => function ($query) use($program) {
			$query->where('program_id', $program->id);
			}]
		);

		/* for generic program data at levels */
		$program = $level->__programs()->where('program_id', $program->id)->first();
		 
		//Throw 404 if program does nor exist at a level
		if(!$program){
		   abort(404);
		}
		 
		$program_levels = $program->__levels()->get();

		$SEOData = new SEOData(
            title: "{$level->name} in {$program->name} in Nigeria",
			description: "Detailed infomation about {$level->name} in {$program->name}",
        );

		return view('program.show', compact('level','program','program_levels','SEOData'));
    }
    
	/* list institutions which have a program */
	public function institutions(Level $level, Program $program) {

		//eager load programs on level for tuition fee range computation
		$level->load([ 'programs' => function ($query) use($program) {
			$query->where('program_id', $program->id);
			}]
		);

		$institutions = $program->institutions()->with(['institutionType','category','state'])->wherePivot('level_id', $level->id)->orderBy('name')->paginate(60);
		$program_levels = $program->__levels()->get();
			
		$SEOData = new SEOData(
			title: "Academic Institutions Offering {$level->name} in {$program->name} in Nigeria",
			description: "Academic institutions offering {$level->name} in {$program->name} Explore the collection of institutions to make informed decisions.",
		);
		
		  return view('program.institutions', compact('level','program','institutions','program_levels','SEOData'));
	}
    
}
