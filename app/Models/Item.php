<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $dates = ['deleted_at'];

 


    protected $fillable = [
        'ar_name', 'en_name' , 'image' , 'room_id' , 'purchase_date' , 'status' , 'last_inventory' ,
         'orical_number' , 
        'room_number' , 
        'major_id' , 
        'minor_id' , 
        'detaild_id' , 
        'uuid'
    ];

    public function Major()
    {
        return $this->belongsTo(Category::class, 'major_id');
    
    }


    public function Minor()
    {
        return $this->belongsTo(Category::class, 'minor_id');
    
    }


    
    public function detailed()
    {
        return $this->belongsTo(Category::class, 'detaild_id');
    
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    

    protected $casts = [
 
    ];



}

