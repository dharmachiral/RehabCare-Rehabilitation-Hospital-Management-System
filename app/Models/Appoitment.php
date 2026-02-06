<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoitment extends Model
{
    use HasFactory;
    protected $table='appoitments';
    protected $fillable =[
        'name','email','contact','service_id','message','status','preferred_time','preferred_date'
    ];
}
