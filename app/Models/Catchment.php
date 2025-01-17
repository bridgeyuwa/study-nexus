<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lukeraymonddowning\SelfHealingUrls\Concerns\HasSelfHealingUrls;

class Catchment extends Model
{
    use HasFactory;
    use HasSelfHealingUrls;
	
	protected  $slug = 'name';
   
     public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }
    
     public function region()
    {
        return $this->belongsTo(Region::class);
    }
    
}
