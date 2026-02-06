@extends('setting::layouts.master')

@section('title', 'Invoice')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Invoice</h1>
    </section>

    <section class="content">
        <div class="card card-body">
            <h3>Invoice #: {{ $invoice->invoice_no }}</h3>
            <p><strong>Student:</strong> {{ $invoice->student->full_name }}</p>
            <p><strong>Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>

            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Fee Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->items as $item)
                        <tr>
                            <td>{{ $item->feeType->name ?? '-' }}</td>
                            <td>{{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th>{{ number_format($invoice->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>
@endsection
