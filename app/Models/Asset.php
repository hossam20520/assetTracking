<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Asset extends Model
{
    protected $table = 'assets';
    protected $dates = ['deleted_at'];
 
   
    protected $fillable = [
        'ar_name', 'purchase_date', 'client_id', 'category_id', 'group_id', 'location_id', 'image' , 'description' 
        , 'status' ,
         'major_id', 'minor_id' , 'detaild_id'
    ];

    protected $casts = [
 
    ];



    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    
    }


    public function Group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    
    }


    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id');
        
    }


    public function Location()
    {
        return $this->belongsTo(Location::class, 'location_id');
 
    }
 

}

