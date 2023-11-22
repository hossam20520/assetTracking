<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfear extends Model
{
    protected $table = 'transfears';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'item_id', 'old_room_id',  
        'old_location_id', 
        'old_floor_id', 
        'user_id', 
        'inventorie', 
        'date', 
    ];
 
 

    protected $casts = [
 
    ];



}

