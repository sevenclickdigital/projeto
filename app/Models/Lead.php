<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'active',
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'birthday',
        'notify_news',
        'notify_holiday',
        'notify_birthday',
        'notify_scratch_card',
        'notify_coupon',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'active' => 'boolean',
        'birthday' => 'date',
        'notify_news' => 'boolean',
        'notify_holiday' => 'boolean',
        'notify_birthday' => 'boolean',
        'notify_scratch_card' => 'boolean',
        'notify_coupon' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function socialLeads()
    {
        return $this->hasMany(SocialLead::class);
    }

    public function scratchCardPlayers()
    {
        return $this->hasMany(ScratchCardPlayer::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
}
