<?php

namespace App\Models;

use App\Contracts\CustomerGroup as ContractsCustomerGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="CustomerGroup",
 *     required={"code", "name", "is_user_defined"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="VIP"),
 *     @OA\Property(property="name", type="string", example="VIP Customers"),
 *     @OA\Property(property="is_user_defined", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
 * )
 */
class CustomerGroup extends Model implements ContractsCustomerGroup
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_user_defined'
    ];
}
