<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Staff extends \Illuminate\Foundation\Auth\User
{
    use HasApiTokens, HasFactory;
    protected $guarded = [];
}
