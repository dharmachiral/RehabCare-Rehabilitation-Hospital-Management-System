@extends('setting::layouts.master')
@section('title', 'All Payments')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Payments</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Payments</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                @can('create_payments')
                    <div class="card-header">
                        <h3 class="card-title float-right">
                            <a href="{{ route('payments.create') }}" class="btn btn-sm btn-success">
                                Create Payment
                            </a>

                        </h3>

                    </div>
                @endcan
                <div class="card-body">
                    @if ($payments->count())
                        <table id="example1" class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Total (Rs)</th>
                                    <th>Receipt</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $payment->student->full_name ?? '-' }}</td>
                                        <td>{{ $payment->payment_date }}</td>
                                        <td>{{ ucfirst($payment->payment_method) }}</td>
                                        <td>{{ number_format($payment->total_amount, 2) }}</td>
                                        <td>
                                            @if ($payment->image)
                                                <a href="{{ asset('storage/' . $payment->image) }}" target="_blank">View
                                                    Receipt</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @can('show_payments')
                                            <a href="{{ route('payments.show', $payment->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Date</th>
                                    <th>Method</th>
                                    <th>Total (Rs)</th>
                                    <th>Receipt</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <p>No payments found.</p>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
