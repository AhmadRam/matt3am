<?php

namespace App\Repositories;

use App\Eloquent\Repository;

class RegisterDeviceRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Contracts\RegisterDevice';
    }
}
