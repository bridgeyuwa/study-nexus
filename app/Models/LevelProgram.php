<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;


class LevelProgram extends Pivot
{
   
   protected $table = 'level_program';
	
    protected $casts = [
	
	'requirements' => SchemalessAttributes::class,
	
	];
	
	
	public function scopeWithRequirements(): Builder
	
	{
		
		return $this->requirements->modelScope();
		
	}




	
   
   
   
   
}
