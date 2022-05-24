<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Staff extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens, HasFactory;
    protected $guarded = [];
    protected static function booted()
    {
        static::creating(function ($staff) {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'staff'");
            $newStaffId = $statement[0]->Auto_increment;
            $idLength = strlen(strval($newStaffId));
            if($idLength === 1){
                $newStaffId = "00" . $newStaffId;
            }else if($idLength === 2){
                $newStaffId = "0" . $newStaffId;
            }
            $staff->staff_id = "CCT" . date("Y") . $newStaffId;
            $staff->password = Hash::make("cctpassword");
        });
    }

    public function batches(){
        return $this->hasMany(ExamBatch::class, "faculty_id");
    }
}
