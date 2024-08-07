<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lukeraymonddowning\SelfHealingUrls\Concerns\HasSelfHealingUrls;

class Category extends Model
{
    use HasFactory;
    use HasSelfHealingUrls;
	
	protected  $slug = 'name';
	
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
    
	public function categoryClass() {
        return $this->belongsTo(CategoryClass::class);
    }
    
}
