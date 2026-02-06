<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no', 'student_id', 'invoice_date', 'total_amount',
        'paid_amount', 'due_amount', 'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
     public function paymentItems()
    {
        return $this->hasManyThrough(PaymentItem::class, InvoiceItem::class, 'invoice_id', 'student_fee_id', 'id', 'id');
    }
}
