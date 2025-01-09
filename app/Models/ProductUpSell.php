<?php

namespace App\Models;

use App\Contracts\Product;
use App\Contracts\ProductUpSell as ContractsProductUpSell;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUpSell extends Model implements ContractsProductUpSell
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
