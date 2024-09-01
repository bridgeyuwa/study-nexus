<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
	
	protected $casts = [ 
	'exam_date' => 'datetime:Y-m-d',
	'start_time' => 'datetime',
	'end_time' => 'datetime'

	];
	
	
	
	public function exam() {
        return $this->belongsTo(Exam::class);
    }
	
	public function subject() {
        return $this->belongsTo(Subject::class);
    }
	
	public function paperType() {
        return $this->belongsTo(PaperType::class);
    }	
	
}
