<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Subcategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable,SoftDeletes;
    protected $table = 'sub_categories';

    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function services()
{
    return $this->hasMany(Service::class, 'sub_category_id');
}

}
