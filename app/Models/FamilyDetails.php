<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyDetails extends Model
{
    use HasFactory;
    protected $table = 'family_details';
    protected $guarded = ['id'];
    
    public function getPhotoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : asset('storage/profile.svg');
    }

}