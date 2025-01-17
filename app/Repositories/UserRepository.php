<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\User;

class UserRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return User::class;
    }
}
