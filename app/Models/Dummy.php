<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    protected $table = 'dummys';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        // 'ar_name', 'en_name', 
    ];

    protected $casts = [
 
    ];



}

