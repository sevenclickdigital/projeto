<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'max_lead',
        'max_branch',
        'facebook_page_id',
        'facebook_access_token',
        'instagram_page_id',
        'instagram_access_token',
        'color_primary',
        'color_secondary',
        'custom_font',
        'participation_terms',
        'privacy',
        'terms_of_use',
    ];

    protected $searchableFields = ['*'];

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function scratchCards()
    {
        return $this->hasMany(ScratchCard::class);
    }

    public function newsletters()
    {
        return $this->hasMany(Newsletter::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function qrbilders()
    {
        return $this->hasMany(Qrbilder::class);
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function categoryProducts()
    {
        return $this->hasMany(CategoryProduct::class);
    }

    public function scratchCardConfigs()
    {
        return $this->hasMany(ScratchCardConfig::class);
    }

    public function scratchCardPlayers()
    {
        return $this->hasMany(ScratchCardPlayer::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function socialLeads()
    {
        return $this->hasMany(SocialLead::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function ratingGoogleBusinesses()
    {
        return $this->hasMany(RatingGoogleBusiness::class);
    }

    public function branchHours()
    {
        return $this->hasMany(BranchHour::class);
    }

    public function birthdays()
    {
        return $this->hasMany(Birthday::class);
    }

    public function holidayDescriptions()
    {
        return $this->hasMany(HolidayDescription::class);
    }
}
