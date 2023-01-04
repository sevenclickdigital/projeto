<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScratchCardPlayer extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = ['tenant_id', 'scratch_card_id', 'lead_id', 'winner'];

    protected $searchableFields = ['*'];

    protected $table = 'scratch_card_players';

    protected $casts = [
        'winner' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function scratchCard()
    {
        return $this->belongsTo(ScratchCard::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
