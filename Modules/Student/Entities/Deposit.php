<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'bank_name',
        'amount',
        'deposited_by',
        'remark',
        'receipt',
    ];
}
