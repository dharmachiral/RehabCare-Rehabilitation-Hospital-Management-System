<?php

namespace Modules\Treatment\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Treatment\Entities\Treatment;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
         abort_if(Gate::denies('show_treatments'), 403);
        $treatment = Treatment::orderBy('created_at','DESC')->get();
        return view('treatment::index',compact('treatment'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_treatments'), 403);
        $treatment = Treatment::orderBy('created_at','DESC')->get();
        // $partners = Partner::orderBy('created_at','DESC')->get();
        return view('treatment::create', compact('treatment',));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(request $request)
    {
        abort_if(Gate::denies('create_treatments'), 403);

        $request->validate([
            'title' => 'required',
            // 'image' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
            'short_description' => 'required',
            'description' => 'required',
        ]);
        if ($request->file('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/treatment'), $image);
        }
        Treatment::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'image' => $image ?? 'N/A',
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status ?? 'on'
        ]);
        return redirect()->route('treatment.index')->with('success','treatment Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        abort_if(Gate::denies('show_treatments'), 403);
        return view('treatment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_treatments'), 403);
        $treatment = Treatment::findOrfail($id);
        // $sectors = ProgramCategory::orderBy('created_at','DESC')->get();
        // $partners = Partner::orderBy('created_at','DESC')->get();
        return view('treatment::edit',compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(request $request, $id)
    {
        abort_if(Gate::denies('edit_treatments'), 403);
        $treatment= Treatment::findOrfail($id);

        if ($request->file('image')) {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/treatment'), $image);
        }else{
            $image = $treatment->image;
        }
        if($request['status'] == 'on')
        {
            $status = 'on';
        }else{
            $status = 'off';
        }
       
        $treatment->update([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'image' => $image,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $status
        ]);
        return redirect()->route('treatment.index')->with('success','data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_treatments'), 403);
        $treatment= Treatment::findOrfail($id);
        $treatment->delete();
        return redirect()->back()->with('success','treatment Deleted!');
    }
    public function Status($id)
    {
        $treatment= Treatment::findOrfail($id);
        if($treatment->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $treatment->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','treatment Updated!');
    }
}
