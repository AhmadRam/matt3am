<?php

namespace App\Models;

use App\Contracts\RegisterDevice as ContractsRegisterDevice;
use Illuminate\Database\Eloquent\Model;


class RegisterDevice extends Model implements ContractsRegisterDevice
{

    // protected $guarded = ['_token'];

    protected $fillable = ['os', 'customer_id', 'fcmToken'];
}
