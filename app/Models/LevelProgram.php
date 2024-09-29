<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;


class LevelProgram extends Pivot
{
   
   protected $table = 'level_program';
	
    protected $casts = [
	
	'updated_at' => 'datetime',
	'requirements' => SchemalessAttributes::class,
	
	];
	
	
	public function scopeWithRequirements(): Builder
	
	{
		
		return $this->requirements->modelScope();
		
	}


/* Added because of Nova */
	public function program() {
        return $this->belongsTo(Program::class);
    }
	
	
	public function level() {
        return $this->belongsTo(Level::class);
    }
	
   
   
   
   
}
