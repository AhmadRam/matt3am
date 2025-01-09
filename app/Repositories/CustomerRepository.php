<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Customer;

class CustomerRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Customer::class;
    }
}
