<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class CustomerDetails extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable,SoftDeletes;
    protected $table = 'customer_details';
    protected $guarded = ['id'];

    public function family(){
        return $this->hasMany(FamilyDetails::class,'customer_id','id');
    }

}