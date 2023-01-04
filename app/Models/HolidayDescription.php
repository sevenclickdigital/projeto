<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HolidayDescription extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'holiday_id',
        'active',
        'when_send',
        'time',
        'subject',
        'content',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'holiday_descriptions';

    protected $casts = [
        'active' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function holiday()
    {
        return $this->belongsTo(Holiday::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
}
