<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ScratchCardAnswer extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'description',
        'sending_order',
        'type',
        'template_type',
        'elements_title',
        'elements_image_url',
        'elements_subtitle',
        'action_type',
        'action_url',
        'action_messenger_extensions',
        'action_webview_height_ratio',
        'buttons_type',
        'buttons_url',
        'buttons_title',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'scratch_card_answers';
}
