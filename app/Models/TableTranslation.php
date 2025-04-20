<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'locale',
        'table_id',
    ];
}
