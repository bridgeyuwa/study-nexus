<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamBody extends Model
{
    use HasFactory;
	
	public function exams() {
        return $this->hasMany(Exam::class);
    }
	
	public function syllabi() {
        return $this->hasMany(Syllabus::class);
    }
	
}
