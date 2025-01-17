<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Table;

class TableRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Table::class;
    }
}
