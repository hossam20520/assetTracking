<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'ar_name', 'parent_id' , 'uuid'
    ];

    protected $casts = [
 
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'parent_id');
       // return $this->hasOne(Country::class, 'parent_id');
    }

    public function relatedLocation()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }



    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    

    public function getFormattedCategories()
    {
        $categories = $this->with('children')->where('parent_id' , 0)->get();

    

        $formattedCategories = [];

        foreach ($categories as $category) {
            $formattedCategories[] = $this->formatCategory($category);
        }

        return implode(' > ', $formattedCategories);
    }

    private function formatCategory($category)
    {
        $formattedCategory = $category->ar_name;

        if ($category->parent) {
            $formattedCategory = $this->formatCategory($category->parent) . ' > ' . $formattedCategory;
        }

        return $formattedCategory;
    }



}

