<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScratchCard extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'published',
        'award_photo_path',
        'name',
        'description',
        'Keyword',
        'chances_of_winning',
        ' play_number',
        'show_day',
        'prize_availability',
        'prize_date_end',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'scratch_cards';

    protected $casts = [
        'prize_date_end' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
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
