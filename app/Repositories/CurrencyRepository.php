<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Currency;

class CurrencyRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Currency::class;
    }
}
