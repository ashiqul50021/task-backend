<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    /*
    |-----------------------------------------------------------------------------
    |IMAGES (RELATION)
    |-----------------------------------------------------------------------------
    */
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }


    /*
    |-----------------------------------------------------------------------------
    |SEARCH (SCOPE)
    |-----------------------------------------------------------------------------
    */
    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';

        return $query->where('name', 'like', $term)
            ->orWhere('description', 'like', $term);
    }
}
