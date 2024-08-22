<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;
	
	 public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }
	
	
	 public function news()
    {
        return $this->belongsToMany(News::class);
    }
}
