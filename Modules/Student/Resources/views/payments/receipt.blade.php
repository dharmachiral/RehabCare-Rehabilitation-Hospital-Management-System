<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body { 
            font-family: 'Arial', sans-serif; 
            margin: 0; 
            padding: 10px; 
            background: #fff; 
            font-size: 12px;
        }
        .receipt { 
            max-width: 280px; 
            margin: 0 auto; 
            border: 1px solid #000; 
            padding: 15px;
            background: white;
        }
        .company-header { 
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .company-logo { 
            max-width: 60px; 
            max-height: 40px;
            margin-bottom: 5px;
        }
        .company-name {
            font-size: 14px;
            font-weight: bold;
            margin: 2px 0;
        }
        .company-address {
            font-size: 10px;
            margin: 2px 0;
            line-height: 1.2;
        }
        .receipt-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin: 8px 0;
            text-transform: uppercase;
        }
        .receipt-number {
            text-align: center;
            font-size: 10px;
            margin: 5px 0;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }
        .info-label {
            font-weight: bold;
            min-width: 80px;
        }
        .info-value {
            text-align: right;
            flex: 1;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 10px;
        }
        .items-table th {
            border-bottom: 1px solid #000;
            padding: 3px 2px;
            text-align: left;
            font-weight: bold;
        }
        .items-table td {
            padding: 2px;
            border-bottom: 1px dotted #ddd;
        }
        .amount {
            text-align: right;
            font-weight: bold;
        }
        .total-row {
            border-top: 2px solid #000;
            font-weight: bold;
            font-size: 11px;
        }
        .footer {
            text-align: center;
            margin-top: 10px;
            padding-top: 8px;
            border-top: 1px solid #000;
            font-size: 9px;
            line-height: 1.2;
        }
        .thank-you {
            font-weight: bold;
            margin: 5px 0;
        }
        .signature-area {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            font-size: 9px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 80px;
            text-align: center;
            padding-top: 2px;
        }
        .item-description {
            font-size: 9px;
            line-height: 1.2;
        }
        
        /* NEW STYLES FOR ADVANCE & DUE INFO */
        .balance-section {
            margin: 8px 0;
            padding: 5px;
            background: #f8f9fa;
            border-radius: 3px;
            font-size: 10px;
        }
        .balance-row {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
        }
        .balance-label {
            font-weight: bold;
        }
        .balance-value {
            font-weight: bold;
        }
        .due-amount {
            color: #dc3545;
        }
        .advance-amount {
            color: #28a745;
        }
        .paid-amount {
            color: #007bff;
        }
        .highlight-box {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 3px;
            padding: 5px;
            margin: 5px 0;
            font-size: 9px;
        }
        
        @media print {
            body { 
                margin: 0; 
                padding: 5px;
            }
            .no-print { 
                display: none; 
            }
            .receipt {
                border: 1px solid #000;
                max-width: 280px;
            }
        }
        .no-print {
            text-align: center;
            margin-top: 15px;
        }
        .print-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 11px;
            margin: 2px;
        }
    </style>
</head>
<body>
    @php
        $company = \Modules\Setting\Entities\CompanyProfile::first();
        
        // Calculate payment breakdown
        $total = 0;
        $advanceAmount = 0;
        $regularAmount = 0;
        $advanceUsed = 0;
        
        foreach($payment->paymentItems as $item) {
            $total += $item->paid_amount;
            if ($item->is_advance) {
                $advanceAmount += $item->paid_amount;
            } else {
                $regularAmount += $item->paid_amount;
            }
        }
        
        // Calculate advance used from remarks
        if ($payment->remarks && (str_contains($payment->remarks, 'advance') || str_contains($payment->remarks, 'Advance'))) {
            preg_match('/Rs?\.[\s]*([0-9,]+(\.[0-9]{2})?)/', $payment->remarks, $matches);
            if (isset($matches[1])) {
                $advanceUsed = (float) str_replace(',', '', $matches[1]);
            }
        }
        
        // Get current student balance and calculate remaining due
        $student = $payment->student;
        $currentAdvanceBalance = $student->balance;
        
        // Calculate remaining due amounts
        $remainingFeesDue = \Modules\Student\Entities\StudentFee::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->get()
            ->sum(function($fee) {
                return $fee->amount - $fee->paid_amount;
            });
            
        $remainingExpensesDue = \Modules\Student\Entities\Expense::where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'partial'])
            ->get()
            ->sum(function($expense) {
                return $expense->amount - $expense->paid_amount;
            });
            
        $totalRemainingDue = $remainingFeesDue + $remainingExpensesDue;
        
        // Calculate previous advance balance (before this payment)
        $previousAdvanceBalance = $currentAdvanceBalance + $advanceUsed - $advanceAmount;
    @endphp

    <div class="receipt">
        <!-- Company Header -->
        <div class="company-header">
            @if($company && $company->logo)
                <img src="{{ asset('upload/images/settings/'.$company->logo) }}" alt="Logo" class="company-logo">
            @endif
            <div class="company-name">{{ $company->company_name ?? 'Ugratara Sudhar Kendra' }}</div>
            @if($company && $company->company_address)
                <div class="company-address">{{ $company->company_address }}</div>
            @endif
            @if($company && $company->company_phone)
                <div class="company-address">Tel: {{ $company->company_phone }}</div>
            @endif
        </div>

        <!-- Receipt Title -->
        <div class="receipt-title">Payment Receipt</div>
        <div class="receipt-number">No: REC-{{ $payment->id }}-{{ date('Ymd') }}</div>

        <div class="divider"></div>

        <!-- Student Information -->
        <div class="info-row">
            <span class="info-label">Student:</span>
            <span class="info-value">{{ $payment->student->full_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Class:</span>
            <span class="info-value">{{ $payment->student->classModel->class_name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Roll No:</span>
            <span class="info-value">{{ $payment->student->roll_no ?? $payment->student->id }}</span>
        </div>

        <div class="divider"></div>

        <!-- Payment Information -->
        <div class="info-row">
            <span class="info-label">Date:</span>
            <span class="info-value">{{ date('d/m/Y', strtotime($payment->payment_date)) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Time:</span>
            <span class="info-value">{{ date('h:i A', strtotime($payment->payment_date)) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Method:</span>
            <span class="info-value" style="text-transform: uppercase;">{{ $payment->payment_method }}</span>
        </div>

        <div class="divider"></div>

        <!-- ====== ADVANCE & DUE SUMMARY ====== -->
        <div class="balance-section">
            <div class="balance-row">
                <span class="balance-label">Advance Used:</span>
                <span class="balance-value due-amount">
                    @if($advanceUsed > 0)
                        Rs. {{ number_format($advanceUsed, 2) }}
                    @else
                        Rs. 0.00
                    @endif
                </span>
            </div>
            <div class="balance-row">
                <span class="balance-label">Cash Payment:</span>
                <span class="balance-value paid-amount">Rs. {{ number_format($regularAmount, 2) }}</span>
            </div>
            <div class="balance-row">
                <span class="balance-label">New Advance:</span>
                <span class="balance-value advance-amount">
                    @if($advanceAmount > 0)
                        Rs. {{ number_format($advanceAmount, 2) }}
                    @else
                        Rs. 0.00
                    @endif
                </span>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Payment Items -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->paymentItems as $index => $item)
                    <tr>
                        <td class="item-description">
                            @if($item->is_advance)
                                <strong>ADVANCE PAYMENT</strong>
                                <br><small>For future payments</small>
                            @elseif($item->studentFee && $item->studentFee->feeType)
                                @php
                                    $feeTypeName = $item->studentFee->feeType->name;
                                    $isAdmission = stripos($feeTypeName, 'admission') !== false;
                                @endphp
                                <strong>{{ $isAdmission ? 'ADMISSION FEE' : strtoupper($feeTypeName) }}</strong>
                                @if(!$isAdmission && $item->studentFee->month && $item->studentFee->year)
                                    <br><small>{{ date('M Y', mktime(0, 0, 0, $item->studentFee->month, 1, $item->studentFee->year)) }}</small>
                                @endif
                            @elseif($item->expense && $item->expense->expenseType)
                                <strong>{{ strtoupper($item->expense->expenseType->name) }}</strong>
                                @if($item->expense->description)
                                    <br><small>{{ substr($item->expense->description, 0, 20) }}{{ strlen($item->expense->description) > 20 ? '...' : '' }}</small>
                                @endif
                            @else
                                <strong>PAYMENT</strong>
                            @endif
                        </td>
                        <td class="amount">{{ number_format($item->paid_amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td><strong>TOTAL PAID</strong></td>
                    <td class="amount"><strong>Rs. {{ number_format($total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- ====== CURRENT BALANCE STATUS ====== -->
        <div class="balance-section">
            <div style="text-align: center; font-weight: bold; margin-bottom: 5px; font-size: 11px;">
                CURRENT BALANCE STATUS
            </div>
            
            <div class="balance-row">
                <span class="balance-label">Advance Balance:</span>
                <span class="balance-value advance-amount">Rs. {{ number_format($currentAdvanceBalance, 2) }}</span>
            </div>
            
            <div class="balance-row">
                <span class="balance-label">Remaining Due:</span>
                <span class="balance-value due-amount">Rs. {{ number_format($totalRemainingDue, 2) }}</span>
            </div>
            
            @if($totalRemainingDue > 0 && $currentAdvanceBalance > 0)
            <div class="highlight-box">
                <strong>💡 Note:</strong> You have Rs. {{ number_format($currentAdvanceBalance, 2) }} advance 
                that can be used for future payments.
            </div>
            @endif
            
            @if($totalRemainingDue == 0)
            <div style="text-align: center; color: #28a745; font-weight: bold; margin-top: 3px;">
                ✅ All dues cleared
            </div>
            @endif
        </div>

        <!-- Payment Summary -->
        <div style="font-size: 9px; margin: 5px 0; padding: 3px; background: #f8f9fa; border-radius: 2px;">
            <strong>Summary:</strong> 
            @php
                $admissionCount = 0;
                $monthlyFeeCount = 0;
                $expenseCount = 0;
                $advanceCount = 0;
                
                foreach($payment->paymentItems as $item) {
                    if ($item->is_advance) {
                        $advanceCount++;
                    } elseif ($item->studentFee && $item->studentFee->feeType) {
                        $feeTypeName = $item->studentFee->feeType->name;
                        if (stripos($feeTypeName, 'admission') !== false) {
                            $admissionCount++;
                        } else {
                            $monthlyFeeCount++;
                        }
                    } elseif ($item->expense) {
                        $expenseCount++;
                    }
                }
            @endphp
            
            @if($admissionCount > 0) Admission({{ $admissionCount }}) @endif
            @if($monthlyFeeCount > 0) Monthly({{ $monthlyFeeCount }}) @endif
            @if($expenseCount > 0) Expense({{ $expenseCount }}) @endif
            @if($advanceCount > 0) Advance({{ $advanceCount }}) @endif
            
            @if($advanceUsed > 0)
                | Advance Used: Rs. {{ number_format($advanceUsed, 2) }}
            @endif
        </div>

        <!-- Remarks -->
        @if($payment->remarks)
        <div style="font-size: 9px; margin: 5px 0; padding: 3px; background: #f5f5f5; border-radius: 2px;">
            <strong>Note:</strong> {{ substr($payment->remarks, 0, 50) }}{{ strlen($payment->remarks) > 50 ? '...' : '' }}
        </div>
        @endif

        <!-- Signature Area -->
        <div class="signature-area">
            <div>
                <div class="signature-line"></div>
                <div>Student/Parent</div>
            </div>
            <div>
                <div class="signature-line"></div>
                <div>Authority</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Thank You!</div>
            <div>Generated: {{ date('d/m/Y H:i') }}</div>
            <div>Computer Generated Receipt</div>
            @if($company && $company->company_phone)
                <div>Contact: {{ $company->company_phone }}</div>
            @endif
        </div>
    </div>

    <!-- Print Controls -->
    <div class="no-print">
        <button onclick="window.print()" class="print-btn">🖨️ Print Receipt</button>
        <button onclick="window.close()" class="print-btn" style="background: #6c757d;">❌ Close</button>
    </div>

    <script>
        // Auto-print when page loads (optional)
        window.onload = function() {
            // Uncomment below line for auto-print
            // window.print();
        };

        // Keyboard shortcut for printing
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
            if (e.key === 'Escape') {
                window.close();
            }
        });
    </script>
</body>
</html>