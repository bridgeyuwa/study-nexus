<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public function programs() {
        return $this->belongsToMany(Program::class,'institution_program','level_id','program_id')->withPivot('institution_id','description','duration','tuition_fee','utme_cutoff','utme_subjects','utme_o_level_req','direct_entry_req');
    }


    public function institutions() {
        return $this->belongsToMany(Institution::class,'institution_program','level_id','institution_id')->withPivot('program_id','description','duration','tuition_fee','utme_cutoff','utme_subjects','utme_o_level_req','direct_entry_req');
    }



// for level_programs relationship
    public function __programs() {
        return $this->belongsToMany(Program::class,'level_program','level_id','program_id')->withPivot('honor_id','description','duration','tuition_fee_low','tuition_fee_high','utme_subjects','utme_o_level_req','direct_entry_req');
    }


    
}
