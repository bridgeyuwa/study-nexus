<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
	
	public function examBody() {
        return $this->belongsTo(ExamBody::class);
    }
	
	public function timetables() {
        return $this->hasMany(Timetable::class);
    }
}
