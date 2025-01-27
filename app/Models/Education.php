<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Education extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable,SoftDeletes;

    protected $table = 'educations';

    protected $fillable = [
        'university_name',
        'start_date',
        'end_date',
        'degree',
        'major',
        'description'
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
