<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Student\Entities\Payment;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'class_id',
        'address',
        'gender',
        'dob',
        'phone',
        'behaviour',
        'blood_group',
        'guardian_name',
        'guardian_phone',
        'image',
        'medical_report',
        'document',
        'admission_date',
        'admission_fee', // Now getting from students table
        'monthly_fee',   // Now getting from students table
        'status',
        'remarks',
        'balance',
        'recover_date',
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    /**
     * Get admission fee from student record
     */
    public function getAdmissionFeeAttribute($value)
    {
        return $value ?? 0;
    }

    /**
     * Get monthly fee from student record
     */
    public function getMonthlyFeeAttribute($value)
    {
        return $value ?? 0;
    }
    // In Student model
public function getTotalExpectedFeesAttribute()
{
    $admissionFee = $this->admission_fee ?? 0;
    $monthlyFee = $this->monthly_fee ?? 0;
    
    $admissionDate = \Carbon\Carbon::parse($this->admission_date);
    $endDate = $this->recover_date ? \Carbon\Carbon::parse($this->recover_date) : \Carbon\Carbon::now();
    $totalMonths = $admissionDate->diffInMonths($endDate) + 1;
    
    return $admissionFee + ($monthlyFee * $totalMonths);
}

public function getNetBalanceAttribute()
{
    $totalPayments = $this->payments->sum('total_amount');
    $totalExpenses = $this->expenses->sum('amount');
    
    return $totalPayments - $totalExpenses;
}
// In your StudentFee model, add this method if it doesn't exist:
public function updatePaidAmount()
{
    $this->paid_amount = $this->paymentItems()->sum('paid_amount');
    
    if ($this->paid_amount >= $this->amount) {
        $this->status = 'paid';
    } elseif ($this->paid_amount > 0) {
        $this->status = 'partial';
    } else {
        $this->status = 'unpaid';
    }
    
    $this->save();
}
}