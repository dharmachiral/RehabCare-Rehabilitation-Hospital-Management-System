<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\FeeStructure;
use Modules\Student\Entities\StudentFee;

class FeeType extends Model
{
    protected $fillable = ['name', 'category', 'is_recurring'];

    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
}
