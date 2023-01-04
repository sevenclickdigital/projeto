<?php

namespace App\Models;

use App\Traits\HasUUID;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasUUID;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tenant_id',
        'category_product_id',
        'type',
        'product_photo_path',
        'name',
        'price',
        'description',
        ' button_text',
        ' button_path',
    ];

    protected $searchableFields = ['*'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProduct::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
}
