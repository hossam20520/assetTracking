<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventore extends Model
{
    protected $table = 'inventores';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'start_session_date' 
    ];

    protected $casts = [
 
    ];



}

