@extends('setting::layouts.master')

@section('title', 'Balance Sheet')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Balance Sheet</h1>
        </section>

        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <!-- Total Cash -->
                    <div class="col-md-3">
                        <div class="card bg-success text-white shadow-sm">
                            <div class="card-body">
                                <h5>Total Cash Received</h5>
                                <h3>Rs. {{ number_format($totalCash, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Expenses -->
                    <div class="col-md-3">
                        <div class="card bg-danger text-white shadow-sm">
                            <div class="card-body">
                                <h5>Total Expenses</h5>
                                <h3>Rs. {{ number_format($totalExpenses, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Cash in Hand -->
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark shadow-sm">
                            <div class="card-body">
                                <h5>Cash in Hand</h5>
                                <h3>Rs. {{ number_format($cashInHand, 2) }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Total Deposits -->
                    <div class="col-md-3">
                        <div class="card bg-info text-white shadow-sm">
                            <div class="card-body">
                                <h5>Total Deposited</h5>
                                <h3>Rs. {{ number_format($totalDeposits, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#depositModal">
                        <i class="fa fa-university"></i> Deposit Cash
                    </button>
                </div>

                <!-- Deposit Modal -->
                <div class="modal fade" id="depositModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <form action="{{ route('balancesheet.storeDeposit') }}" method="POST" enctype="multipart/form-data"
                            class="modal-content">
                            @csrf
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Deposit Cash to Bank</h5>
                                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input type="number" step="0.01" name="amount" class="form-control" required
                                        max="{{ $cashInHand }}">
                                </div>
                                <div class="form-group">
                                    <label>Deposited By</label>
                                    <input type="text" name="deposited_by" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Remark</label>
                                    <textarea name="remark" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Receipt (optional)</label>
                                    <input type="file" name="receipt" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Deposit Now</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
