<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Newsletter extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'active',
        'sent',
        'date',
        'time',
        'subject',
        'content',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'active' => 'boolean',
        'sent' => 'boolean',
        'date' => 'date',
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
