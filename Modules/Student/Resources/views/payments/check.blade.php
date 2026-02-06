 @if (isset($fees) && $fees->count())
                            <div class="table-responsive mb-4">
                                <h5 class="text-primary"><i class="fas fa-money-check-alt"></i> admission Fees
                                    </h5>
                                <table class="table table-bordered table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Fee Type</th>
                                            <th>Period</th>
                                            <th>Stay Period</th>
                                            <th class="text-right">Original Amount (Rs.)</th>
                                            <th class="text-right">Paid Amount (Rs.)</th>
                                            <th class="text-right">Remaining Amount (Rs.)</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- In the fees table --}}
                                        @foreach ($fees->where('fee_type_id', $admissionFeeType?->id) as $i => $admission)
                                            @php
                                                $remainingAmount =
                                                    $admission->remaining_amount ??
                                                    $admission->amount - $admission->paid_amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $admission->feeType->name }}</td>
                                                <td>One-time</td>
                                                <td>-</td>
                                                <td class="text-right">{{ number_format($admission->amount, 2) }}</td>
                                                <td class="text-right text-success">
                                                    {{ number_format($admission->paid_amount, 2) }}</td>
                                                <td class="text-right text-danger">
                                                    <strong>{{ number_format($remainingAmount, 2) }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if ($admission->paid_amount >= $admission->amount)
                                                        <span class="badge badge-success">Paid</span>
                                                    @elseif($admission->paid_amount > 0)
                                                        <span class="badge badge-warning">Partial</span>
                                                    @else
                                                        <span class="badge badge-danger">Unpaid</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                            </div>
                        @endif