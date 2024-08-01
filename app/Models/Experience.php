<?php

 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'company_name',
        'city',
        'state',
        'start_date',
        'end_date',
        'currently_working',
        'work_summary'
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
