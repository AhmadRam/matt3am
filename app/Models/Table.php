<?php

namespace App\Models;

use App\Contracts\Table as ContractsTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 *     schema="Table",
 *     required={"name", "section_id"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Table 1"),
 *     @OA\Property(property="capacity", type="integer", example=4),
 *     @OA\Property(property="qr_code", type="string", example="https://example.com/qr-code.png"),
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="meta_title", type="string", example="Table 1 Meta Title"),
 *     @OA\Property(property="meta_keywords", type="string", example="table, dining"),
 *     @OA\Property(property="meta_description", type="string", example="Table 1 description"),
 *     @OA\Property(property="section_id", type="integer", example=2),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T00:00:00Z")
 * )
 */
class Table extends Model implements ContractsTable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'qr_code',
        'status',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'section_id'
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(SectionProxy::modelClass());
    }
}
