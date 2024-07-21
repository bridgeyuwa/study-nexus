<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditationStatus extends Model
{
    use HasFactory;
	
	
	public function institutionPrograms() {
        return $this->hasMany(InstitutionProgram::class);
    }
	
	
	public function institutions() {
        return $this->hasMany(Institution::class);
    }
}
