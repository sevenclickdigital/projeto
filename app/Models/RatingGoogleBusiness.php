<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RatingGoogleBusiness extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['tenant_id', 'name', 'text', 'stars'];

    protected $searchableFields = ['*'];

    protected $table = 'rating_google_businesses';

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
}
