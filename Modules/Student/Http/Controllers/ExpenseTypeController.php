<?php

namespace Modules\Student\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Student\Entities\ExpenseType;

class ExpenseTypeController extends Controller
{
    public function index()
    {
        $types = ExpenseType::latest()->paginate(10);
        return view('student::expense_types.index', compact('types'));
    }

    public function create()
    {
        return view('student::expense_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:expense_types,name',
        ]);

        ExpenseType::create($request->only('name', 'description'));

        return redirect()->route('expense-types.index')->with('success', 'Expense Type added successfully.');
    }

    public function edit($id)
    {
        $type = ExpenseType::findOrFail($id);
        return view('student::expense_types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = ExpenseType::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:100|unique:expense_types,name,' . $id,
        ]);

        $type->update($request->only('name', 'description'));

        return redirect()->route('expense-types.index')->with('success', 'Expense Type updated successfully.');
    }

    public function destroy($id)
    {
        ExpenseType::findOrFail($id)->delete();
        return redirect()->route('expense-types.index')->with('success', 'Deleted successfully.');
    }
}
