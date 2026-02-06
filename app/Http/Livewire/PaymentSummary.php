<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Student\Entities\Payment;
use Carbon\Carbon;

class PaymentSummary extends Component
{
    public $period = '1';
    public $startDate;
    public $endDate;
    public $showCustomRange = false;
    public $filteredAmounts = [
        'totalAmount' => 0,
        'totalPaid' => 0,
        'totalDue' => 0
    ];
    public $periodText = 'Today';

    public function mount()
    {
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
        $this->applyFilters();
    }

    public function updated($property)
    {
        if ($property === 'period') {
            $this->showCustomRange = $this->period === 'custom';
            $this->applyFilters();
        }
    }

    public function applyFilters()
    {
        $query = Payment::query();

        switch ($this->period) {
            case '1': // Today
                $query->whereDate('payment_date', today());
                $this->periodText = 'Today (' . now()->format('M d, Y') . ')';
                break;
            case '7': // Last 7 days
                $query->where('payment_date', '>=', now()->subDays(7));
                $this->periodText = 'Last 7 days (' . now()->subDays(7)->format('M d, Y') . ' - ' . now()->format('M d, Y') . ')';
                break;
            case '30': // Last 30 days
                $query->where('payment_date', '>=', now()->subDays(30));
                $this->periodText = 'Last 30 days (' . now()->subDays(30)->format('M d, Y') . ' - ' . now()->format('M d, Y') . ')';
                break;
            case '365': // Last year
                $query->where('payment_date', '>=', now()->subDays(365));
                $this->periodText = 'Last year (' . now()->subDays(365)->format('M d, Y') . ' - ' . now()->format('M d, Y') . ')';
                break;
            case 'custom': // Custom date range
                if ($this->startDate && $this->endDate) {
                    $query->whereBetween('payment_date', [
                        Carbon::parse($this->startDate)->startOfDay(),
                        Carbon::parse($this->endDate)->endOfDay()
                    ]);
                    $this->periodText = 'Custom (' . Carbon::parse($this->startDate)->format('M d, Y') . ' - ' . Carbon::parse($this->endDate)->format('M d, Y') . ')';
                } else {
                    $this->periodText = 'All time';
                }
                break;
            default:
                $this->periodText = 'All time';
        }

        $payments = $query->get();

        $this->filteredAmounts = [
            'totalAmount' => $payments->sum('total_amount'),
            'totalPaid' => $payments->sum('amount_paid'),
            'totalDue' => $payments->sum('amount_due'),
        ];
    }

    public function render()
    {
        return view('livewire.payment-summary');
    }
}
