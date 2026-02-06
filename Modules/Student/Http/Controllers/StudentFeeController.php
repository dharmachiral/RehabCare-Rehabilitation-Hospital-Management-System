<?php
namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Entities\{StudentFee, FeeType};

class StudentFeeController extends Controller
{
    public function index($student_id)
    {
        $fees = StudentFee::where('student_id', $student_id)->with('feeType')->get();
        return view('student::fees.student.index', compact('fees', 'student_id'));
    }

    public function create($student_id)
    {
        $feeTypes = FeeType::all();
        return view('student::fees.student.create', compact('feeTypes', 'student_id'));
    }

    public function store(Request $request)
    {
        $request->validate(['fee_type_id' => 'required', 'amount' => 'required|numeric']);
        StudentFee::create($request->all());
        return redirect()->back()->with('success', 'Student fee added!');
    }
}
