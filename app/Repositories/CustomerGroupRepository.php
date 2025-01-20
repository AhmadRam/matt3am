<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\CustomerGroup;

class CustomerGroupRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return CustomerGroup::class;
    }
}
