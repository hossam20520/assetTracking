<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name' 
    ];

    protected $casts = [
 
    ];



}

