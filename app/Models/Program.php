<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model {

    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function college() {
        return $this->belongsTo(College::class);
    }



// add "specific" as prefix to the many to many relationship for all functions of institution_program_level

    public function institutions() {
        return $this->belongsToMany(Institution::class,'institution_program','program_id','institution_id')->withPivot('level_id','description','duration','tuition_fee','utme_cutoff','utme_subjects','utme_o_level_req','direct_entry_req');
    }

    
    
    public function levels() {
        return $this->belongsToMany(Level::class,'institution_program','program_id','level_id')->withPivot('institution_id','description','duration','tuition_fee','utme_cutoff','utme_subjects','utme_o_level_req','direct_entry_req');
    }



// for level_program relationship

public function __levels() {
        return $this->belongsToMany(Program::class,'level_program','program_id','level_id')->withPivot('honor_id','description','duration','tuition_fee_low','tuition_fee_high','utme_subjects','utme_o_level_req','direct_entry_req');
    }

   
    public function honor() {
        return $this->belongsTo(Honor::class);
    }

}



