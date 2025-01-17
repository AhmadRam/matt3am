<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\Menu;

class MenuRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Menu::class;
    }
}
