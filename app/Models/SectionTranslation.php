<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'locale',
        'section_id',
    ];
}
