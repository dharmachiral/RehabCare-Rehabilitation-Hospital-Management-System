<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = ['class_id', 'fee_type_id', 'amount', 'session_year'];

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
      public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
