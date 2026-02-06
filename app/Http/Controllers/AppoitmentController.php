<?php

namespace App\Http\Controllers;

use App\Models\Appoitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AppoitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('show_appointments'), 403);
        $appoitment = appoitment::all();
        return view('backend.pages.appoitment',compact('appoitment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   
    {
        
    $preferred_time = date('H:i:s', strtotime($request->preferred_time));
    $preferred_date = date('Y-m-d', strtotime($request->preferred_date));
    $appoitment = appoitment::create([
        'name' => $request->name,
        'email' => $request->email,
        'contact' => $request->contact,
        'message' => $request->message,
        'preferred_date' => $preferred_date,
        'preferred_time' => $preferred_time,
    ]);
        return back()->with('success','Your appointment Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('delete_appoitments'), 403);
        $appoitment = appoitment::findOrfail($id);
        $appoitment->delete();
        return back()->with('success','Successfully deleted');
    }
}
