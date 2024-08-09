<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

class InstitutionProgram extends Pivot
{   

    protected $table = 'institution_program';
	
    protected $casts = [
	
	'requirements' => SchemalessAttributes::class,
	
	];
	
	
	public function scopeWithRequirements(): Builder
	
	{
		
		return $this->requirements->modelScope();
		
	}
	
	
	public function accreditationBody() {
        return $this->belongsTo(AccreditationBody::class);
    }
	
	public function accreditationStatus() {
        return $this->belongsTo(AccreditationStatus::class);
    }
	
	
	
	public function programMode() {
        return $this->belongsTo(ProgramMode::class);
    }
	
	/* Added because of Nova */
	public function program() {
        return $this->belongsTo(Program::class);
    }
	
	public function institution() {
        return $this->belongsTo(Institution::class);
    }
	
	public function level() {
        return $this->belongsTo(Level::class);
    }
	
}
