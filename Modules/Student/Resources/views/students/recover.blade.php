
<div class="col-sm-6">
                        <h1 class="m-0">
                            <div class="student-status-section">
                                @if ($student->status == 'on')
                                    <!-- Current Student - Show date picker before recovering -->
                                    <div class="card card-warning">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-clock fa-2x text-warning mr-3"></i>
                                                    
                                                </div>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div class="form-group mb-0">
                                                        <label class="form-label mb-1 small font-weight-bold">Recovery Date</label>
                                                        <input type="date" 
                                                               id="recover-date-{{ $student->id }}" 
                                                               class="form-control" 
                                                               style="width: 160px;"
                                                               value="{{ now()->format('Y-m-d') }}"
                                                               min="2000-01-01"
                                                               max="{{ now()->format('Y-m-d') }}"
                                                               required>
                                                    </div>
                                                    <button type="button" 
                                                            class="btn btn-warning btn-flat"
                                                            onclick="confirmRecovery({{ $student->id }})">
                                                        <i class="fa fa-user-injured mr-2"></i> Mark as Recovered
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Recovered Student - Show recover button -->
                                    <div class="card card-success">
                                        <div class="card-body py-2">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user-check fa-2x text-success mr-3"></i>
                                                    <div>
                                                        <h5 class="mb-0 font-weight-bold">Recovered Student</h5>
                                                        <small class="text-muted">
                                                            Recovered on: {{ $student->recover_date ? \Carbon\Carbon::parse($student->recover_date)->format('M d, Y') : 'N/A' }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <button type="button" 
                                                        class="btn btn-success btn-flat"
                                                        onclick="makeCurrentStudent({{ $student->id }})">
                                                    <i class="fa fa-user-plus mr-2"></i> Make Current Student
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </h1>
                    </div>
<!-- Hidden Forms -->
    <form id="recover-form" action="{{ route('student.status', $student->id) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="off">
        <input type="hidden" name="recover_date" id="recover-date-input" value="">
    </form>

    <form id="current-form" action="{{ route('student.status', $student->id) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="on">
        <input type="hidden" name="recover_date" value="">
    </form>

<script>
function confirmRecovery(studentId) {
    console.log('confirmRecovery function called for student:', studentId);
    
    const dateInput = document.getElementById('recover-date-' + studentId);
    const hiddenInput = document.getElementById('recover-date-input');
    const selectedDate = dateInput.value;
    
    console.log('Selected Date:', selectedDate);
    
    if (!selectedDate) {
        alert('Please select a recovery date.');
        return false;
    }
    
    // Validate date is not in future
    const selectedDateObj = new Date(selectedDate);
    const today = new Date();
    today.setHours(23, 59, 59, 999);
    
    if (selectedDateObj > today) {
        alert('Recovery date cannot be in the future. Please select today or a past date.');
        return false;
    }
    
    // Update the hidden input value with selected date
    hiddenInput.value = selectedDate;
    
    console.log('Hidden Input Value:', hiddenInput.value);
    
    // Format date for display
    const formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    // Show confirmation with the selected date
    if (confirm(`Are you sure you want to mark this student as recovered?\n\nRecovery Date: ${formattedDate}`)) {
        console.log('Submitting recover form...');
        document.getElementById('recover-form').submit();
        return true;
    }
    return false;
}

function makeCurrentStudent(studentId) {
    console.log('makeCurrentStudent function called for student:', studentId);
    
    if (confirm('Are you sure you want to mark this student as Current Student?')) {
        console.log('Submitting current form...');
        document.getElementById('current-form').submit();
        return true;
    }
    return false;
}

// Add event listener for Enter key on date input
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('recover-date-{{ $student->id }}');
    if (dateInput) {
        dateInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                confirmRecovery({{ $student->id }});
            }
        });
        
        // Auto-focus for better UX
        setTimeout(() => {
            dateInput.focus();
        }, 100);
    }
    
    // Debug: Check if elements exist
    console.log('Date Input:', document.getElementById('recover-date-{{ $student->id }}'));
    console.log('Hidden Input:', document.getElementById('recover-date-input'));
    console.log('Recover Form:', document.getElementById('recover-form'));
    console.log('Current Form:', document.getElementById('current-form'));
});
</script>
