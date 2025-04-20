<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'address',
        'logo',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'locale',
        'restaurant_id',
    ];
}
