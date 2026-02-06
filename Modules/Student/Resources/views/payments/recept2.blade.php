<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background: #fff; 
        }
        .receipt { 
            max-width: 800px; 
            margin: 0 auto; 
            border: 2px solid #333; 
            padding: 20px; 
        }
        .company-header { 
            display: flex; 
            align-items: center; 
            justify-content: space-between;
            border-bottom: 2px solid #333; 
            padding-bottom: 15px; 
            margin-bottom: 20px; 
        }
        .company-info { 
            flex: 1; 
        }
        .company-logo { 
            max-width: 120px; 
            max-height: 80px; 
        }
        .logo-container {
            text-align: right;
            flex-shrink: 0;
            margin-left: 20px;
        }
        .receipt-header { 
            text-align: center; 
            margin: 15px 0; 
        }
        .receipt-header h1 { 
            margin: 10px 0; 
            color: #333; 
            font-size: 24px;
        }
        .receipt-header p { 
            margin: 5px 0; 
            color: #666; 
        }
        .details { 
            margin-bottom: 20px; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        .table th { 
            background-color: #f5f5f5; 
            font-weight: bold;
        }
        .text-right { 
            text-align: right; 
        }
        .text-center { 
            text-align: center; 
        }
        .total { 
            font-weight: bold; 
            font-size: 1.1em; 
            background-color: #f8f9fa;
        }
        .footer { 
            margin-top: 30px; 
            padding-top: 15px; 
            border-top: 2px solid #333; 
            text-align: center; 
            color: #666;
            font-size: 12px;
        }
        .company-contact {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }
        .receipt-number {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .signature-area {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            text-align: center;
            padding-top: 5px;
        }
        @media print {
            body { 
                margin: 0; 
            }
            .no-print { 
                display: none; 
            }
            .receipt {
                border: none;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    @php
        $company = \Modules\Setting\Entities\CompanyProfile::first();
    @endphp

    <div class="receipt">
        <!-- Company Header with Logo -->
        <div class="company-header">
            <div class="company-info">
                @if($company)
                    <h2 style="margin: 0; color: #333;">{{ $company->company_name ?? 'Ugratara sudhar kendra' }}</h2>
                    @if($company->company_address)
                        <p style="margin: 5px 0; color: #666; font-size: 14px;">
                            {{ $company->company_address }}
                        </p>
                    @endif
                    @if($company->company_phone || $company->company_email)
                        <div class="company-contact">
                            @if($company->company_phone)
                                <span>Tel: {{ $company->company_phone }}</span>
                            @endif
                            @if($company->company_email)
                                <span> | Email: {{ $company->company_email }}</span>
                            @endif
                        </div>
                    @endif
                @else
                    <h2 style="margin: 0; color: #333;">School Management System</h2>
                    <p style="margin: 5px 0; color: #666;">Professional Education Services</p>
                @endif
            </div>
            
            <div class="logo-container">
                @if($company && $company->logo)
                    <img src="{{ asset('upload/images/settings/'.$company->logo) }}" alt="Company Logo" class="company-logo">
                @else
                    <div style="width: 120px; height: 80px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;">
                        <span style="color: #999; font-size: 12px;">No Logo</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Receipt Header -->
        <div class="receipt-header">
            <h1>PAYMENT RECEIPT</h1>
            <div class="receipt-number">
                <strong>Receipt No:</strong> REC-{{ $payment->id }}-{{ date('Ymd') }}
            </div>
        </div>

        <!-- Student and Payment Details -->
        <div class="details">
            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="margin-bottom: 10px; color: #333; border-bottom: 1px solid #eee; padding-bottom: 5px;">Student Information</h3>
                    <p><strong>Name:</strong> {{ $payment->student->full_name }}</p>
                    <p><strong>Class:</strong> {{ $payment->student->classModel->class_name ?? 'N/A' }}</p>
                    <p><strong>Roll No:</strong> {{ $payment->student->roll_no ?? $payment->student->id }}</p>
                    @if($payment->student->parent_name)
                        <p><strong>Parent:</strong> {{ $payment->student->parent_name }}</p>
                    @endif
                </div>
                <div style="flex: 1; min-width: 250px;">
                    <h3 style="margin-bottom: 10px; color: #333; border-bottom: 1px solid #eee; padding-bottom: 5px;">Payment Details</h3>
                    <p><strong>Date:</strong> {{ date('d M Y', strtotime($payment->payment_date)) }}</p>
                    <p><strong>Time:</strong> {{ date('h:i A', strtotime($payment->payment_date)) }}</p>
                    <p><strong>Method:</strong> <span style="text-transform: capitalize; background: #e3f2fd; padding: 2px 8px; border-radius: 3px;">{{ $payment->payment_method }}</span></p>
                    <p><strong>Status:</strong> <span style="color: #28a745; font-weight: bold;">{{ ucfirst($payment->status) }}</span></p>
                </div>
            </div>
        </div>

        <!-- Payment Items Table -->
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="50%">Description</th>
                    <th width="20%">Type</th>
                    <th width="25%" class="text-right">Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($payment->paymentItems as $index => $item)
                    @php $total += $item->paid_amount; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($item->is_advance)
                                <strong>Advance Payment</strong>
                                <br><small style="color: #666;">Credit for future payments</small>
                            @elseif($item->studentFee)
                                <strong>{{ $item->studentFee->feeType->name ?? 'Fee Payment' }}</strong>
                                @if($item->studentFee->month)
                                    <br><small style="color: #666;">
                                        Period: {{ date('M Y', mktime(0, 0, 0, $item->studentFee->month, 1, $item->studentFee->year)) }}
                                    </small>
                                @endif
                            @elseif($item->expense)
                                <strong>{{ $item->expense->expenseType->name ?? 'Expense Payment' }}</strong>
                                @if($item->expense->description)
                                    <br><small style="color: #666;">{{ $item->expense->description }}</small>
                                @endif
                            @else
                                <strong>Payment</strong>
                            @endif
                        </td>
                        <td>
                            @if($item->is_advance)
                                <span style="color: #e67e22; font-weight: bold;">Advance</span>
                            @else
                                <span style="color: #27ae60; font-weight: bold;">Payment</span>
                            @endif
                        </td>
                        <td class="text-right" style="font-weight: bold;">
                            {{ number_format($item->paid_amount, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="3" class="text-right"><strong>Total Amount Paid:</strong></td>
                    <td class="text-right" style="font-size: 1.1em;">
                        <strong>Rs. {{ number_format($total, 2) }}</strong>
                    </td>
                </tr>
                @if($payment->total_amount > $total)
                <tr>
                    <td colspan="3" class="text-right"><strong>Advance Added:</strong></td>
                    <td class="text-right" style="color: #e67e22;">
                        + Rs. {{ number_format($payment->total_amount - $total, 2) }}
                    </td>
                </tr>
                @endif
            </tfoot>
        </table>

        <!-- Remarks -->
        @if($payment->remarks)
        <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 5px; border-left: 4px solid #007bff;">
            <strong>Remarks:</strong> {{ $payment->remarks }}
        </div>
        @endif

        <!-- Signature Area -->
        <div class="signature-area">
            <div>
                <div class="signature-line"></div>
                <div style="text-align: center; margin-top: 5px;">Student/Parent Signature</div>
            </div>
            <div>
                <div class="signature-line"></div>
                <div style="text-align: center; margin-top: 5px;">Authority</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            
                <p>Thank you for your payment! This receipt is proof of your transaction.</p>
    
            
            @if($company)
                <p>
                    @if($company->company_phone)Tel: {{ $company->company_phone }} | @endif
                    @if($company->company_email)Email: {{ $company->company_email }} | @endif
                    @if($company->company_address)Address: {{ $company->company_address }}@endif
                </p>
            @endif
            
            <p>
                <strong>Generated on:</strong> {{ date('d M Y, h:i A') }} | 
                <strong>Receipt ID:</strong> REC-{{ $payment->id }}-{{ date('Ymd') }}
            </p>
            <p style="font-style: italic; margin-top: 10px;">
                This is a computer generated receipt. No signature is required.
            </p>
        </div>
    </div>

    <!-- Print Controls -->
    <div class="no-print" style="text-align: center; margin-top: 20px; padding: 20px; background: #f8f9fa; border-radius: 10px;">
        <button onclick="window.print()" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin: 0 10px;">
            🖨️ Print Receipt
        </button>
        <button onclick="window.close()" style="background: #6c757d; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin: 0 10px;">
            ❌ Close Window
        </button>
        <button onclick="downloadReceipt()" style="background: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin: 0 10px;">
            📥 Download PDF
        </button>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            // Optional: Uncomment the line below to auto-print
            // window.print();
        };

        // Download as PDF function
        function downloadReceipt() {
            window.print();
        }

        // Add keyboard shortcut for printing (Ctrl+P)
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
