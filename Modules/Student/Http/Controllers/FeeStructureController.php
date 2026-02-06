<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Entities\FeeStructure;
use Modules\Student\Entities\ClassModel;
use Modules\Student\Entities\FeeType;

class FeeStructureController extends Controller
{
    public function index()
    {
        $feeStructures = FeeStructure::with(['feeType', 'classModel'])->latest()->paginate(10);
        return view('student::fee_structures.index', compact('feeStructures'));
    }

    public function create()
    {
        $classes = ClassModel::all();
        $feeTypes = FeeType::all();
        return view('student::fee_structures.create', compact('classes', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric',
            'session_year' => 'required',
        ]);

        FeeStructure::create($request->all());
        return redirect()->route('fee-structures.index')->with('success', 'Fee Structure added!');
    }

    public function edit($id)
    {
        $feeStructure = FeeStructure::findOrFail($id);
        $classes = ClassModel::all();
        $feeTypes = FeeType::all();
        return view('student::fee_structures.edit', compact('feeStructure', 'classes', 'feeTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric',
            'session_year' => 'required',
        ]);

        $feeStructure = FeeStructure::findOrFail($id);
        $feeStructure->update($request->all());

        return redirect()->route('fee-structures.index')->with('success', 'Fee Structure updated!');
    }

    public function destroy($id)
    {
        $feeStructure = FeeStructure::findOrFail($id);
        $feeStructure->delete();

        return redirect()->route('fee-structures.index')->with('success', 'Fee Structure deleted!');
    }
}
