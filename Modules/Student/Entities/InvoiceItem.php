<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Invoice;
use Modules\Student\Entities\FeeType;
use Modules\Student\Entities\StudentFee;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'fee_type_id',
        'student_fee_id', // include this if you added it to table
        'description',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    /**
     * Link invoice item to its student fee
     */
    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }
}
