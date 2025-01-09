<?php

namespace App\Repositories;

use App\Eloquent\Repository;

class CurrencyRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'App\Contracts\Currency';
    }
}
