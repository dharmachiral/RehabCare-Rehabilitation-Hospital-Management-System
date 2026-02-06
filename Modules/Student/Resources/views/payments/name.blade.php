<form action="{{ route('payments.global.show-form') }}" method="GET" class="mb-4">

        <div class="card-body bg-light">
            <div class="row align-items-end">
               <div class="col-md-8">
    <div class="form-group">
        <label class="font-weight-bold text-dark">
            <i class="fas fa-user-graduate mr-1 text-primary"></i> Select Student 
            <span class="text-danger">*</span>
        </label>
        <select name="student_id" class="form-control select2" required>
            <option value="">-- Select Student --</option>
            @foreach ($students as $s)
                <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->id }} - {{ $s->full_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>


                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-block shadow">
                        <i class="fas fa-search mr-2"></i> Load Student Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Student",
        allowClear: true,
        width: '100%'
    });
});
</script>
