<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'active',
        'title',
        'description',
        'code',
        'coupon_type',
        'limit',
        'start_date',
        'expire_date',
        'min_purchase',
        'max_discount',
        'discount_type',
        'discount',
        'when_send',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'active' => 'boolean',
        'start_date' => 'date',
        'expire_date' => 'date',
        'when_send' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
}
