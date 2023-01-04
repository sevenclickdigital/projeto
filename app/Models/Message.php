<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'social_lead_id',
        'text',
        'read',
        'message_key',
        'sender',
        'sender_id',
        'receiver_id',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function socialLead()
    {
        return $this->belongsTo(SocialLead::class);
    }
}
