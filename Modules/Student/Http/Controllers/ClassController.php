<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Student\Entities\ClassModel;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::latest()->paginate(10);
        return view('student::classes.index', compact('classes'));
    }

    public function create()
    {
        return view('student::classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
        ]);

        ClassModel::create($request->all());
        return redirect()->route('classes.index')->with('success', 'Class added successfully!');
    }

    public function edit($id)
    {
        $class = ClassModel::findOrFail($id);
        return view('student::classes.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
        ]);

        $class = ClassModel::findOrFail($id);
        $class->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Class updated successfully!');
    }

    public function destroy($id)
    {
        $class = ClassModel::findOrFail($id);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully!');
    }
}
