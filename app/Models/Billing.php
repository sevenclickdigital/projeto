<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Billing extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'tenant_id'];

    protected $searchableFields = ['*'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
