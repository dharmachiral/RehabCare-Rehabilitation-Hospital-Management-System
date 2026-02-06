<?php

namespace Modules\Student\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Modules\Student\Entities\Student;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Support\Renderable;
use Modules\Student\Entities\ClassModel;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_students'), 403);
        $students = Student::with('user')->where('status', 'on')->latest()->get();
        return view('student::students.index', compact('students'));
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index2()
    {
        abort_if(Gate::denies('show_students2'), 403);
        $students = Student::with('user')->where('status', 'off')->latest()->get();
        return view('student::students.index2', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    abort_if(Gate::denies('create_students'), 403);
    
    // Debug: Check what data is being loaded
    $classes = ClassModel::with(['feeStructures.feeType'])->get();
    
    // Debug output - remove this after testing
    foreach ($classes as $class) {
        Log::info("Class: {$class->class_name}");
        foreach ($class->feeStructures as $feeStructure) {
            Log::info("Fee Type: " . ($feeStructure->feeType->name ?? 'N/A') . " - Amount: {$feeStructure->amount}");
        }
    }
    
    return view('student::students.create', compact('classes'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    abort_if(Gate::denies('create_students'), 403);
    DB::beginTransaction();

    try {
        // Base validation rules
        $validationRules = [
            'full_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            // 'address' => 'nullable|string',
            'gender' => 'required|in:male,female,other',
            // 'dob' => 'nullable|date',
            // 'phone' => 'nullable|string|max:15',
            // 'behaviour' => 'nullable|string',
            // 'blood_group' => 'nullable|in:A+,A-,B+,AB+,AB-,O+,O-',
            // 'guardian_name' => 'nullable|string|max:255',
            // 'guardian_phone' => 'nullable|string|max:15',
            'admission_date' => 'required|date',
            'admission_fee' => 'required|numeric|min:0',
            'monthly_fee' => 'required|numeric|min:0',
        ];

        $validated = $request->validate($validationRules);

        // Generate username and password automatically
        $randomNumber = rand(1000, 9999);
        $username = strtolower(Str::slug($validated['full_name'])) . $randomNumber;
        $passwordPlain = $validated['full_name'] . '@123';

        // Create user account
        $user = User::create([
            'username' => $username,
            'email' => $username . '@student.local',
            'password' => Hash::make($passwordPlain),
            'role' => 'student'
        ]);

        // Handle file uploads
        $filePaths = [
            'payment_receipt' => null,
        ];

        $image = null;
        if ($request->file('image')) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/Students'), $image);
        }

        $medicalReport = null;
        if ($request->file('medical_report')) {
            $medicalReport = time() . '_medical.' . $request->medical_report->extension();
            $request->medical_report->move(public_path('upload/files/Students'), $medicalReport);
        }

        $document = null;
        if ($request->file('document')) {
            $document = time() . '_document.' . $request->document->extension();
            $request->document->move(public_path('upload/files/Students'), $document);
        }

        $paymentReceiptPath = null;
        if ($request->payment_status !== 'pending' && $request->file('payment_receipt')) {
            $paymentReceiptPath = $request->payment_receipt->store('payments', 'public');
        }

        // Create student record with custom fees
        $student = $user->student()->create([
            'full_name' => $validated['full_name'],
            'class_id' => $validated['class_id'],
            'address' => $validated['address']?? null,
            'gender' => $validated['gender'],
            'dob' => $validated['dob']?? null,
            'phone' => $validated['phone']?? null,
            'behaviour' => $validated['behaviour'] ?? null,
            'blood_group' => $validated['blood_group'] ?? null,
            'guardian_name' => $validated['guardian_name'] ?? null,
            'guardian_phone' => $validated['guardian_phone'] ?? null,
            'image' => $image,
            'medical_report' => $medicalReport,
            'document' => $document,
            'admission_date' => $validated['admission_date'],
            'admission_fee' => $validated['admission_fee'],
            'monthly_fee' => $validated['monthly_fee'],
        ]);

        DB::commit();

        return redirect()->route('student.index')
            ->with('success', "Student created successfully. Username: $username, Password: $passwordPlain");
    } catch (\Exception $e) {
        DB::rollBack();
        $this->cleanupOnFailure($user ?? null, $filePaths ?? []);

        return back()->withInput()
            ->with('error', 'Error creating student: ' . $e->getMessage());
    }
}

    /**
     * Handle file upload and return stored path
     */
    private function handleFileUpload($file, string $directory): ?string
    {
        if (!$file) return null;

        $extension = $file->extension();
        $fileName = time() . '_' . Str::random(10) . '.' . $extension;
        $file->move(public_path("upload/{$directory}"), $fileName);

        return $fileName;
    }

    /**
     * Cleanup resources if something fails
     */
    private function cleanupOnFailure(?User $user, array $filePaths): void
    {
        if ($user) {
            $user->delete();
        }

        foreach ($filePaths as $type => $path) {
            if ($path) {
                $directory = match ($type) {
                    'image' => 'students/images',
                    'medical_report', 'document' => 'students/files',
                    'payment_receipt' => 'payments',
                    default => ''
                };

                if ($directory && file_exists(public_path("upload/{$directory}/{$path}"))) {
                    unlink(public_path("upload/{$directory}/{$path}"));
                }
            }
        }
    }

    /**
     * Show the specified resource.
     */
public function show($id)
{
    abort_if(Gate::denies('view_students'), 403);
    $student = Student::with([
        'user',
        'expenses' => function($query) {
            $query->orderBy('expense_date', 'desc');
        },
        'expenses.expenseType',
        'payments' => function($query) {
            $query->orderBy('payment_date', 'desc');
        },
        'payments.paymentItems'
    ])->findOrFail($id);

    // Calculate fee details
    $feeDetails = $this->calculateFeeDetails($student);

    return view('student::students.profile', [
        'student' => $student,
        'feeDetails' => $feeDetails,
    ]);
}

private function calculateFeeDetails($student)
{
    $admissionFee = $student->admission_fee ?? 0;
    $monthlyFee = $student->monthly_fee ?? 0;
    
    $admissionDate = \Carbon\Carbon::parse($student->admission_date);
    
    // Set end date - if recover date exists, use it, otherwise use today
    $endDate = $student->recover_date ? \Carbon\Carbon::parse($student->recover_date) : \Carbon\Carbon::now();
    
    // Calculate monthly fees - pass student object to check recover_date
    $monthlyFeesBreakdown = $this->calculateMonthlyFees($admissionDate, $endDate, $monthlyFee, $student->recover_date);
    
    // Get expenses
    $totalExpenses = $student->expenses->sum('amount');
    $totalPaidExpenses = $student->expenses->sum('paid_amount');
    $totalDueExpenses = $student->expenses->sum('due_amount');
    
    // Calculate total expected income
    $totalAdmissionFee = $admissionFee;
    $totalMonthlyFee = $monthlyFeesBreakdown['total_monthly_fee'];
    $totalExpectedIncome = $totalAdmissionFee + $totalMonthlyFee + $totalExpenses;
    
    // Get actual payments
    $totalPayments = $student->payments->sum('total_amount');
    
    // Calculate remaining/due money
    $remainingMoney = $totalPayments - $totalExpectedIncome;
    
    return [
        'admission_fee' => $admissionFee,
        'monthly_fee' => $monthlyFee,
        'admission_date' => $student->admission_date,
        'recover_date' => $student->recover_date,
        'calculation_end_date' => $endDate->format('Y-m-d'),
        'total_months' => $monthlyFeesBreakdown['total_months'],
        'monthly_breakdown' => $monthlyFeesBreakdown['breakdown'],
        'total_admission_fee' => $totalAdmissionFee,
        'total_monthly_fee' => $totalMonthlyFee,
        'total_expenses' => $totalExpenses,
        'total_paid_expenses' => $totalPaidExpenses,
        'total_due_expenses' => $totalDueExpenses,
        'total_expected_income' => $totalExpectedIncome,
        'total_payments' => $totalPayments,
        'remaining_money' => $remainingMoney,
        'remaining_status' => $remainingMoney >= 0 ? 'positive' : 'negative',
    ];
}

private function calculateMonthlyFees($startDate, $endDate, $monthlyFee, $recoverDate = null)
{
    $breakdown = [];
    $totalMonthlyFee = 0;

    $currentMonth = $startDate->copy()->startOfMonth();
    $hasRecoverDate = !is_null($recoverDate);

    while ($currentMonth <= $endDate) {

        $monthStart = $currentMonth->copy()->startOfMonth();
        $monthEnd   = $currentMonth->copy()->endOfMonth();

        $isAdmissionMonth = $currentMonth->format('Y-m') == $startDate->format('Y-m');
        $isCurrentMonth   = $currentMonth->format('Y-m') == now()->format('Y-m');

        /** -----------------------------
         * 1. ADMISSION MONTH LOGIC
         * -----------------------------*/
        if ($isAdmissionMonth) {

            // Admission month always starts from admission date
            $periodStart = $startDate->copy();

            if (!$hasRecoverDate) {
                // Student active → use end of month
                $periodEnd = $monthEnd->copy();
            } else {
                // Recovered → stop at recover date
                $periodEnd = $endDate->lessThan($monthEnd) ? $endDate : $monthEnd;
            }

        } else {

            /** -----------------------------------------
             * 2. CURRENT MONTH (NOT ADMISSION MONTH)
             * -----------------------------------------*/
            if ($isCurrentMonth && !$hasRecoverDate) {
                // Student active → full month
                $periodStart = $monthStart->copy();
                $periodEnd   = $monthEnd->copy();
            } else {
                // Recovered or past month
                $periodStart = $monthStart->copy();
                $periodEnd   = $endDate->lessThan($monthEnd) ? $endDate : $monthEnd;
            }
        }

        // Safety: skip invalid periods
        if ($periodEnd < $periodStart) {
            break;
        }

        $daysCovered = $periodStart->diffInDays($periodEnd) + 1;
        $daysInMonth = $monthStart->daysInMonth;

        $monthlyFeeProportion = ($daysCovered / $daysInMonth) * $monthlyFee;

        $breakdown[] = [
            'month'         => $currentMonth->format('M Y'),
            'period'        => $periodStart->format('d M') . ' - ' . $periodEnd->format('d M'),
            'days_covered'  => $daysCovered,
            'days_in_month' => $daysInMonth,
            'monthly_fee'   => $monthlyFeeProportion,
            'is_full_month' => $daysCovered == $daysInMonth
        ];

        $totalMonthlyFee += $monthlyFeeProportion;

        $currentMonth->addMonth()->startOfMonth();
    }

    return [
        'breakdown'       => $breakdown,
        'total_monthly_fee' => $totalMonthlyFee,
        'total_months'      => count($breakdown)
    ];
}



    /**
     * Show the form for editing the specified resource.
     */
   public function edit($id)
{
    abort_if(Gate::denies('edit_students'), 403);
    
    $student = Student::with('user')->findOrFail($id);
    $classes = ClassModel::with(['feeStructures.feeType'])->get(); // Load with fee structures
    
    return view('student::students.edit', compact('student', 'classes'));
}

public function update(Request $request, $id): RedirectResponse
{
    abort_if(Gate::denies('edit_students'), 403);
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'class_id' => 'required|exists:classes,id',
        'email' => 'required|email|unique:users,email,' . $student->user_id,
        'password' => 'nullable|string|min:8|confirmed',
        // 'address' => 'nullable|string',
        'gender' => 'required|in:male,female,other',
        // 'dob' => 'nullable|date',
        // 'phone' => 'nullable|string|max:15',
        // 'behaviour' => 'nullable|string',
        // 'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
        // 'guardian_name' => 'nullable|string|max:255',
        // 'guardian_phone' => 'nullable|string|max:15',
        'admission_fee' => 'required|numeric|min:0',
        'monthly_fee' => 'required|numeric|min:0',
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // 'medical_report' => 'nullable|file|mimes:pdf,jpeg,png,jpg,doc,docx|max:2048',
        // 'document' => 'nullable|file|mimes:pdf,jpeg,png,jpg,doc,docx|max:2048',
    ]);

    try {
        // Update user account
        $userData = [
            'email' => $validated['email'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $student->user->update($userData);

        // Initialize variables with existing values
        $image = $student->image;
        $medicalReport = $student->medical_report;
        $document = $student->document;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($student->image && file_exists(public_path('upload/images/Students/' . $student->image))) {
                unlink(public_path('upload/images/Students/' . $student->image));
            }

            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/Students'), $image);
        }

        // Handle medical report upload
        if ($request->hasFile('medical_report')) {
            // Delete old medical report if exists
            if ($student->medical_report && file_exists(public_path('upload/files/Students/' . $student->medical_report))) {
                unlink(public_path('upload/files/Students/' . $student->medical_report));
            }

            $medicalReport = time() . '_medical.' . $request->medical_report->extension();
            $request->medical_report->move(public_path('upload/files/Students'), $medicalReport);
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            // Delete old document if exists
            if ($student->document && file_exists(public_path('upload/files/Students/' . $student->document))) {
                unlink(public_path('upload/files/Students/' . $student->document));
            }

            $document = time() . '_document.' . $request->document->extension();
            $request->document->move(public_path('upload/files/Students'), $document);
        }

        // Update student record with fee data
        $studentData = [
            'full_name' => $validated['full_name'],
            'class_id' => $validated['class_id'],
            'address' => $validated['address']?? null,
            'gender' => $validated['gender'],
            'dob' => $validated['dob']?? null,
            'phone' => $validated['phone']?? null,
            'behaviour' => $validated['behaviour']?? null,
            'blood_group' => $validated['blood_group']?? null,
            'guardian_name' => $validated['guardian_name']?? null,
            'guardian_phone' => $validated['guardian_phone']?? null,
            'admission_fee' => $validated['admission_fee'],
            'monthly_fee' => $validated['monthly_fee'],
            'image' => $image,
            'medical_report' => $medicalReport,
            'document' => $document,
        ];

        $student->update($studentData);

        return redirect()->route('student.index')
            ->with('success', 'Student updated successfully.');
    } catch (\Exception $e) {
        return back()->withInput()
            ->with('error', 'Error updating student: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_students'), 403);
        $student = Student::findOrFail($id);

        try {
            // Delete associated files
            if ($student->image) {
                // For image path: upload/images/Students/filename.jpg
                $imagePath = str_replace('upload/images/Students/', '', $student->image);
                Storage::disk('public')->delete('upload/images/Students/' . $imagePath);
            }

            if ($student->medical_report) {
                // For medical report path: upload/files/Students/filename.pdf
                $medicalPath = str_replace('upload/files/Students/', '', $student->medical_report);
                Storage::disk('public')->delete('upload/files/Students/' . $medicalPath);
            }

            // Delete user account
            if ($student->user) {
                $student->user->delete();
            }

            // Delete student record
            $student->delete();

            return redirect()->route('student.index')
                ->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting student: ' . $e->getMessage());
        }
    }

    /**
     * Handle file upload
     */
    private function uploadFile(Request $request, $fieldName, $storagePath, $oldPath = null)
    {
        if ($request->hasFile($fieldName)) {
            // Delete old file if exists
            if ($oldPath && Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }

            return $request->file($fieldName)->store($storagePath, 'public');
        }

        return null;
    }
    /**
     * Change student status
     */
   public function status(Request $request, $id)
{
    $student = Student::findOrFail($id);
    
    if ($student->status === 'on') {
        // Changing from Current Student to Recovered Student
        $student->status = 'off';
        $student->recover_date = $request->recover_date ?? now()->format('Y-m-d');
    } else {
        // Changing from Recovered Student back to Current Student
        $student->status = 'on';
        $student->recover_date = null;
    }
    
    $student->save();

    $statusMessage = $student->status === 'on' ? 'Current Student' : 'Recovered Student';
    return redirect()->back()->with('success', "Student status updated to {$statusMessage} successfully.");
}
}
