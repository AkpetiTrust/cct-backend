<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Student extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens, HasFactory;
    protected $guarded = [];
    protected static function booted(){
        static::creating(function ($student) {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'students'");
            $newStudentId = $statement[0]->Auto_increment;
            $idLength = strlen(strval($newStudentId));
            if($idLength === 1){
                $newStudentId = "00" . $newStudentId;
            }else if($idLength === 2){
                $newStudentId = "0" . $newStudentId;
            }
            $student->registration_number = "REG" . date("Y") . $newStudentId;
            $student->password = Hash::make("cctpassword");
        });
    }

    public function courses(){
        return $this->belongsToMany(Course::class);
    }

}
