<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventorie extends Model
{
    use HasFactory;
  


    public function session(){

        
        return $this->belongsTo(Session::class, 'session_id');  

    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }


    public function sessions()
    {
        return $this->hasMany('\App\Models\Session', 'session_id');
    }



}
