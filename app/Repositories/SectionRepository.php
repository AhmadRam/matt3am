<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Section;

class SectionRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Section::class;
    }
}
