                        <!-- Student Dropdown -->
                      <div class="col-md-6 mb-3">
                            <label>Student</label>
                            <select name="student_id" class="form-control select2" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">
                                        [{{ $student->id }}] {{ $student->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Select Student",
        allowClear: true
    });
});
</script>
