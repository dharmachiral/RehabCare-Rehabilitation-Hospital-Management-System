<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Entities\Expense;
use Modules\Student\Entities\Student;
use Modules\Student\Entities\ExpenseType;

class ExpenseController extends Controller
{
    // Show all expenses
    public function index()
    {
        $expenses = Expense::with(['student', 'expenseType'])->latest()->paginate(10);
        return view('student::expenses.index', compact('expenses'));
    }

    // Show form to add expense
    public function create()
    {
        $students = Student::all();
        $expenseTypes = ExpenseType::all();
        return view('student::expenses.create', compact('students', 'expenseTypes'));
    }
    public function createForCurrentStudent($student_id)
{
    // Get only the current student
    $student = Student::findOrFail($student_id);
    $expenseTypes = ExpenseType::all();

    return view('student::expenses.create2', compact('student', 'expenseTypes'));
}



    // Store new expense
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'expense_type_id' => 'required|exists:expense_types,id',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        Expense::create([
            'student_id' => $request->student_id,
            'expense_type_id' => $request->expense_type_id,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'description' => $request->description,
            'status' => 'unpaid',
            'paid_amount' => 0,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    // Edit expense
    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        $students = Student::all();
        $expenseTypes = ExpenseType::all();
        return view('student::expenses.edit', compact('expense', 'students', 'expenseTypes'));
    }

    // Update expense
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'expense_type_id' => 'required|exists:expense_types,id',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $expense->update([
            'student_id' => $request->student_id,
            'expense_type_id' => $request->expense_type_id,
            'amount' => $request->amount,
            'expense_date' => $request->expense_date,
            'description' => $request->description,
        ]);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    // Delete expense
    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
