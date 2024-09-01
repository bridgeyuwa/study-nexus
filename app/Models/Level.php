<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lukeraymonddowning\SelfHealingUrls\Concerns\HasSelfHealingUrls;

class Level extends Model
{
    use HasFactory;
	use HasSelfHealingUrls;
	
	protected  $slug = 'name';
    
    public function programs() {
        return $this->belongsToMany(Program::class,'institution_program')->using(InstitutionProgram::class)->withPivot('tuition_fee');
    }


    public function institutions() {
        return $this->belongsToMany(Institution::class,'institution_program')->using(InstitutionProgram::class);
    }



// for level_programs relationship
    public function __programs() {
        return $this->belongsToMany(Program::class,'level_program')->using(LevelProgram::class)->withPivot('description','requirements','duration','updated_at');
    }


    
}
