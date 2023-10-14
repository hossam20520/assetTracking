<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    protected $table = 'builds';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'location_id'    , 'uuid'
    ];

    protected $casts = [
 
    ];


    public function location()
    {

        return $this->belongsTo('App\Models\Location' , 'location_id');
        
    }

}

