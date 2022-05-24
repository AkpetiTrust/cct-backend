<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function faculties(){
        return $this->belongsToMany(Staff::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class);
    }

    public function batches(){
        return $this->hasMany(ExamBatch::class);
    }
}
