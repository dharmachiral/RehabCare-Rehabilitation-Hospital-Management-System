<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Entities\FeeType;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::latest()->paginate(10);
        return view('student::fee_types.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('student::fee_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        FeeType::create($request->all());
        return redirect()->route('fee-types.index')->with('success', 'Fee Type added!');
    }

    // ---------------- Edit ----------------
    public function edit($id)
    {
        $feeType = FeeType::findOrFail($id);
        return view('student::fee_types.edit', compact('feeType'));
    }

    // ---------------- Update ----------------
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $feeType = FeeType::findOrFail($id);
        $feeType->update($request->all());

        return redirect()->route('fee-types.index')->with('success', 'Fee Type updated!');
    }

    // ---------------- Delete ----------------
    public function destroy($id)
    {
        $feeType = FeeType::findOrFail($id);
        $feeType->delete();

        return redirect()->route('fee-types.index')->with('success', 'Fee Type deleted!');
    }
}
