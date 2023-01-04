<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['tenant_id', 'name', 'date', 'active', 'custom'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date' => 'date',
        'active' => 'boolean',
        'custom' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function holidayDescriptions()
    {
        return $this->hasMany(HolidayDescription::class);
    }
}
