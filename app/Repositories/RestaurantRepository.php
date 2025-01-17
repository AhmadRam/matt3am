<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Restaurant;

class RestaurantRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Restaurant::class;
    }
}
