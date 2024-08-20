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
        return $this->belongsToMany(Program::class,'institution_program')->using(InstitutionProgram::class)->withPivot('institution_id','description','duration','tuition_fee','requirements','utme_cutoff','accreditation_body_id','accreditation_status_id','accreditation_grant_date','accreditation_expiry_date','program_mode_id','is_distinguished','remarks');
    }


    public function institutions() {
        return $this->belongsToMany(Institution::class,'institution_program')->using(InstitutionProgram::class)->withPivot('program_id','description','duration','tuition_fee','requirements','utme_cutoff','accreditation_body_id','accreditation_status_id','accreditation_grant_date','accreditation_expiry_date','program_mode_id','is_distinguished','remarks');
    }



// for level_programs relationship
    public function __programs() {
        return $this->belongsToMany(Program::class,'level_program')->using(LevelProgram::class)->withPivot('description','requirements','duration');
    }


    
}
