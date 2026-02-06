<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Payment;
use Modules\Student\Entities\StudentFee;

class PaymentItem extends Model
{
    protected $fillable = [
        'payment_id', 
        'student_fee_id', 
        'expense_id', 
        'paid_amount', 
        'is_advance'
    ];

    // Make these relationships optional
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class)->withDefault();
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class)->withDefault();
    }

    // Scope for advance payments
    public function scopeAdvance($query)
    {
        return $query->where('is_advance', true);
    }

    // Scope for regular payments (not advance)
    public function scopeRegular($query)
    {
        return $query->where('is_advance', false);
    }

    // Accessor for description
    public function getDescriptionAttribute()
    {
        if ($this->is_advance) {
            return 'Advance Payment';
        }
        
        if ($this->studentFee) {
            return $this->studentFee->feeType->name ?? 'Fee Payment';
        }
        
        if ($this->expense) {
            return $this->expense->expenseType->name ?? 'Expense Payment';
        }
        
        return 'Payment';
    }
}