<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lukeraymonddowning\SelfHealingUrls\Concerns\HasSelfHealingUrls;

class Region extends Model {

    use HasFactory;
	use HasSelfHealingUrls;
	
	protected  $slug = 'name';

    public function states() {
        return $this->hasMany(State::class);
    }

    public function institutions() {
        return $this->hasManyThrough(Institution::class, State::class);
    }
   
 
    public function catchments() {
        return $this->hasMany(Catchment::class);
    }
  
   
   

}
