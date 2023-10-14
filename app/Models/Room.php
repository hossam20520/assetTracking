<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'en_name', 'uuid'  , 'room_number'
    ];

    protected $casts = [
 
    ];



    

    public function floor()
    {

        return $this->belongsTo('App\Models\Build' , 'build_id');
        
    }

    public function items()
    {

        return $this->hasMany('App\Models\Item' , 'room_id');
        
    }



}

