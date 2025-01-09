<?php

namespace App\Repositories;

use App\Eloquent\Repository;

class ProductImageRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'App\Contracts\ProductImage';
    }
}
