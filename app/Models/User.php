<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Model implements Auditable
{
    use HasApiTokens,\OwenIt\Auditing\Auditable,SoftDeletes;

    protected $fillable = [
        'firstName',
        'lastName',
       'email',       
    ];   
}
