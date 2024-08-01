<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'university_name',
        'start_date',
        'end_date',
        'degree',
        'major',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
