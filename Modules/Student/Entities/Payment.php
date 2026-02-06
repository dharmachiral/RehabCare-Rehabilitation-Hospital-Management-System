<?php
namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Entities\Student;
use Modules\Student\Entities\PaymentItem;

class Payment extends Model
{
    protected $fillable = ['student_id', 'payment_date', 'total_amount', 'payment_method', 'remarks', 'status',
    'image'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
