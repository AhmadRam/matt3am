<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Contracts\Customer as ContractsCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Customer",
 *     description="Customer model",
 *     type="object",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="first_name", type="string"),
 *     @OA\Property(property="last_name", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="phone", type="string"),
 *     @OA\Property(property="gender", type="string"),
 *     @OA\Property(property="date_of_birth", type="string", format="date"),
 *     @OA\Property(property="customer_group_id", type="integer"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Customer extends Authenticatable implements JWTSubject, ContractsCustomer
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'email',
        'phone_code',
        'phone',
        'image',
        'password',
        'api_token',
        'is_verified',
        'token',
        'notes',
        'customer_group_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function customerGroup(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
