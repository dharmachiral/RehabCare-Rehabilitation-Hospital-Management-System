<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Payment;
use Modules\Student\Entities\StudentFee;
use Modules\Student\Entities\Expense;

class PaymentItem extends Model
{
    protected $fillable = [
        'payment_id', 
        'student_fee_id', 
        'expense_id', 
        'paid_amount', 
        'is_advance'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class, 'student_fee_id');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class, 'expense_id');
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

    // Accessor for item type
    public function getItemTypeAttribute()
    {
        if ($this->is_advance) {
            return 'advance';
        }
        
        if ($this->student_fee_id) {
            return 'fee';
        }
        
        if ($this->expense_id) {
            return 'expense';
        }
        
        return 'other';
    }

    // Accessor for description
    public function getDescriptionAttribute()
    {
        if ($this->is_advance) {
            return 'Advance Payment';
        }
        
        if ($this->studentFee) {
            $feeTypeName = $this->studentFee->feeType->name ?? 'Fee Payment';
            // Check if it's admission fee
            if (stripos($feeTypeName, 'admission') !== false) {
                return 'Admission Fee';
            }
            return $feeTypeName;
        }
        
        if ($this->expense) {
            return $this->expense->expenseType->name ?? 'Expense Payment';
        }
        
        return 'Payment';
    }

    // Accessor for detailed description
    public function getDetailedDescriptionAttribute()
    {
        if ($this->is_advance) {
            return 'Advance payment for future use';
        }
        
        if ($this->studentFee) {
            $feeType = $this->studentFee->feeType;
            $description = $feeType->name ?? 'Fee Payment';
            
            if ($this->studentFee->month && $this->studentFee->year) {
                $description .= ' - ' . date('F Y', mktime(0, 0, 0, $this->studentFee->month, 1, $this->studentFee->year));
            }
            
            return $description;
        }
        
        if ($this->expense) {
            $expenseType = $this->expense->expenseType;
            $description = $expenseType->name ?? 'Expense Payment';
            
            if ($this->expense->description) {
                $description .= ' - ' . $this->expense->description;
            }
            
            return $description;
        }
        
        return 'Payment item';
    }

    // Helper method to check if it's admission fee
    public function isAdmissionFee()
    {
        if ($this->is_advance || !$this->studentFee) {
            return false;
        }
        
        $feeTypeName = $this->studentFee->feeType->name ?? '';
        return stripos($feeTypeName, 'admission') !== false;
    }

    // Helper method to get month/year for fee
    public function getPeriodAttribute()
    {
        if ($this->studentFee && $this->studentFee->month && $this->studentFee->year) {
            return date('M Y', mktime(0, 0, 0, $this->studentFee->month, 1, $this->studentFee->year));
        }
        return null;
    }
}