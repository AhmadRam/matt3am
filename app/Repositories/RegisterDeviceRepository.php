<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\RegisterDevice;

class RegisterDeviceRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return RegisterDevice::class;
    }
}
