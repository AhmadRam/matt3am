<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\CurrencyExchangeRate;

class CurrencyExchangeRateRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return  CurrencyExchangeRate::class;
    }
}
