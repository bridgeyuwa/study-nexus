<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryClass extends Model
{
    use HasFactory;
	
	public function categories()
    {
        return $this->hasMany(Category::class);
    }
	
	
	public function institutions()
    {
        return $this->hasManyThrough(Institution::class, Category::class);
    }
	
}
