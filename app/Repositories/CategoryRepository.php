<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Category;

class CategoryRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Category::class;
    }
}
