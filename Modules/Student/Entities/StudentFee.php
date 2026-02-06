<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student;
use Modules\Student\Entities\FeeType;

class StudentFee extends Model
{
    protected $fillable = [
        'student_id', 'fee_type_id', 'month', 'year', 'amount', 'status', 'paid_amount'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'student_fee_id');
    }

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class, 'student_fee_id');
    }

    /**
     * Calculate remaining amount dynamically
     */
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    /**
     * Update paid amount when payments are made
     */
    public function updatePaidAmount()
    {
        $totalPaid = $this->paymentItems()->sum('paid_amount');
        $this->paid_amount = $totalPaid;
        $this->status = ($totalPaid >= $this->amount) ? 'paid' : (($totalPaid > 0) ? 'partial' : 'unpaid');
        $this->save();
    }
}