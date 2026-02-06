{{-- resources/views/student/invoices/index.blade.php --}}
@extends('setting::layouts.master')

@section('title', 'Invoices')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Invoice List</h3>
                <div class="card-tools">
                    <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Create Invoice
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Student</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->student->full_name }}</td>
                                    <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                                    <td class="text-right">Rs. {{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="text-right text-success">Rs. {{ number_format($invoice->paid_amount, 2) }}</td>
                                    <td class="text-right text-danger">Rs. {{ number_format($invoice->due_amount, 2) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($invoice->status == 'paid') badge-success
                                            @elseif($invoice->status == 'partial') badge-warning
                                            @elseif($invoice->status == 'overdue') badge-danger
                                            @else badge-secondary @endif">
                                            {{ strtoupper($invoice->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('invoices.show', $invoice->id) }}" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('invoices.print', $invoice->id) }}" 
                                           class="btn btn-sm btn-secondary" title="Print" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection