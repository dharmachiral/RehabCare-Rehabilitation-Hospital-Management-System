<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student;
use Modules\Student\Entities\PaymentItem;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'expense_type_id',
        'amount',
        'expense_date',
        'description',
        'status',
        'paid_amount',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function getDueAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    // 👇 Add this relation
    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
