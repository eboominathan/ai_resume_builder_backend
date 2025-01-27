<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable,SoftDeletes;

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
