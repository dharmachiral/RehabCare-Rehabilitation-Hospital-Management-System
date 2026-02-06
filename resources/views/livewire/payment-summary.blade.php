<div>
    <!-- Payment Summary Cards -->
    <div class="row mb-3">
        <div class="col-md-12 mb-3">
            <div class="btn-group" role="group" id="period-filter">
                <input type="radio" class="btn-check" name="period" id="period1" value="1" autocomplete="off"
                    wire:model="period">
                <label class="btn btn-outline-primary" for="period1">Today</label>

                <input type="radio" class="btn-check" name="period" id="period7" value="7" autocomplete="off"
                    wire:model="period">
                <label class="btn btn-outline-primary" for="period7">7 Days</label>

                <input type="radio" class="btn-check" name="period" id="period30" value="30" autocomplete="off"
                    wire:model="period">
                <label class="btn btn-outline-primary" for="period30">1 Month</label>

                <input type="radio" class="btn-check" name="period" id="period365" value="365" autocomplete="off"
                    wire:model="period">
                <label class="btn btn-outline-primary" for="period365">1 Year</label>

                <input type="radio" class="btn-check" name="period" id="periodCustom" value="custom" autocomplete="off"
                    wire:model="period">
                <label class="btn btn-outline-primary" for="periodCustom">Custom</label>
            </div>

            @if($showCustomRange)
                <div class="row mt-2">
                    <div class="col-md-5">
                        <input type="date" class="form-control" wire:model="startDate">
                    </div>
                    <div class="col-md-5">
                        <input type="date" class="form-control" wire:model="endDate">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" wire:click="applyFilters">Apply</button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Summary Cards -->
        <div class="col-md-4">
            <div class="card bg-info">
                <div class="card-body">
                    <h5 class="card-title">Total Amount</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">रु {{ number_format($filteredAmounts['totalAmount'], 2) }}</h2>
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <small class="text-white">{{ $periodText }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Paid</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">रु {{ number_format($filteredAmounts['totalPaid'], 2) }}</h2>
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <small class="text-white">{{ $periodText }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Total Due</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">रु {{ number_format($filteredAmounts['totalDue'], 2) }}</h2>
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                    <small class="text-white">{{ $periodText }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
