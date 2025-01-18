<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    // Table name (optional if it matches the default 'services')
    protected $table = 'services';

    // Mass assignable attributes
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'description',
        'amount',
        'payment_status',
        'comments',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
}
