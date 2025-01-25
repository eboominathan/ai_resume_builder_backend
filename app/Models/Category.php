<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sub_categories()
    {
        return $this->hasMany(Subcategory::class);
    }
    public function services()
{
    return $this->hasMany(Service::class, 'category_id');
}
}
