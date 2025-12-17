<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Lukeraymonddowning\SelfHealingUrls\Concerns\HasSelfHealingUrls;

class News extends Model
{
    use HasFactory;
	use HasSelfHealingUrls;
	
	protected  $slug = 'title';
	
	public function institution() {
        return $this->belongsTo(Institution::class);
    }
	
	 public function newsCategories()
    {
        return $this->belongsToMany(NewsCategory::class);
    }

    public function getReadTimeAttribute()
    {
        $content = str_word_count(strip_tags($this->content));
        $minutes = ceil($content / 200);

        return $minutes;
    }
}
