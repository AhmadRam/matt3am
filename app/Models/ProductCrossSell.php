<?php

namespace App\Models;

use App\Contracts\ProductCrossSell as ContractsProductCrossSell;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCrossSell extends Model implements ContractsProductCrossSell
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'child_id'
    ];

    public function parent() : BelongsTo
    {
        return $this->belongsTo(ProductProxy::modelClass(), 'parent_id');
    }

    public function child() : BelongsTo
    {
        return $this->belongsTo(ProductProxy::modelClass(), 'child_id');
    }
}
