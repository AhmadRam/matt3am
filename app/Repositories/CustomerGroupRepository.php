<?php

namespace App\Repositories;

use App\Eloquent\Repository;

class CustomerGroupRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return 'App\Contracts\CustomerGroup';
    }
}
