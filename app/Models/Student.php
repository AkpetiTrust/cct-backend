<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens, HasFactory;
    protected $guarded = [];
}
