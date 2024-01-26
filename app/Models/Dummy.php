<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dummy extends Model
{
    protected $table = 'dummys';
    protected $dates = ['deleted_at'];
 
    protected $fillable = [
        'room_name', 'item_name', 'room_number', 'floor', 'status', 'note', 
    ];

    protected $casts = [
 
    ];



}

