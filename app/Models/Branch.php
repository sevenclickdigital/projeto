<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'branch_logo_path',
        'branch_cover_path',
        'name',
        'currency',
        'description',
        'slug',
        'phone',
        'cell',
        'email',
        'place_id',
        'coordinates',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    protected $searchableFields = ['*'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branchHours()
    {
        return $this->hasMany(BranchHour::class);
    }

    public function leads()
    {
        return $this->belongsToMany(Lead::class);
    }

    public function scratchCards()
    {
        return $this->belongsToMany(ScratchCard::class);
    }

    public function newsletters()
    {
        return $this->belongsToMany(Newsletter::class);
    }

    public function ratings()
    {
        return $this->belongsToMany(Rating::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function birthdays()
    {
        return $this->belongsToMany(Birthday::class, 'branch_birthday');
    }

    public function ratingGoogleBusinesses()
    {
        return $this->belongsToMany(RatingGoogleBusiness::class);
    }

    public function categoryProducts()
    {
        return $this->belongsToMany(CategoryProduct::class);
    }

    public function holidayDescriptions()
    {
        return $this->belongsToMany(HolidayDescription::class);
    }

    public function qrbilders()
    {
        return $this->belongsToMany(Qrbilder::class);
    }

    public function scratchCardConfigs()
    {
        return $this->belongsToMany(ScratchCardConfig::class);
    }
}
