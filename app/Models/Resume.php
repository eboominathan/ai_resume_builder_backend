<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'last_name', 'resumeId','title', 'address', 'phone', 'email', 'theme_color', 'summary'
    ];

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}
