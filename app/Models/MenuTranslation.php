<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuTranslation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'locale',
        'menu_id'
    ];
}
