<?php

namespace Modules\Service\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Service\Entities\Baf;
use Illuminate\Support\Facades\Gate;

class BafController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         abort_if(Gate::denies('baf_services'), 403);
        $baf = Baf::first();
        return view('service::service.baf', compact('baf'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         abort_if(Gate::denies('baf_services'), 403);
        return view('service::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         abort_if(Gate::denies('baf_services'), 403);
        $data = [];
        
        if($request->hasFile('before_image')) {
            $imageName = time().'.'.$request->before_image->extension();
            $request->before_image->move(public_path('upload/images/services'), $imageName);
            $data['before_image'] = $imageName;
        }
        
        if($request->hasFile('image2')) {
            $imageName2 = time().'_2.'.$request->image2->extension();
            $request->image2->move(public_path('upload/images/services'), $imageName2);
            $data['image2'] = $imageName2;
        }
        
        Baf::create($data);
        
        return redirect()->route('baf.index')->with('success','Images Created Successfully');   
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
         abort_if(Gate::denies('baf_services'), 403);
        return view('service::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         abort_if(Gate::denies('baf_services'), 403);
        $baf = Baf::findOrFail($id);
        return view('service::baf.edit', compact('baf'));
    }
    
    public function update(Request $request, $id)
    {
         abort_if(Gate::denies('baf_services'), 403);
        $baf = Baf::findOrFail($id);
        
        $data = [];
        
        if($request->hasFile('before_image')) {
            $imageName = time().'.'.$request->before_image->extension();
            $request->before_image->move(public_path('upload/images/services'), $imageName);
            $data['before_image'] = $imageName;
        }
        
        if($request->hasFile('image2')) {
            $imageName2 = time().'_2.'.$request->image2->extension();
            $request->image2->move(public_path('upload/images/services'), $imageName2);
            $data['image2'] = $imageName2;
        }
        
        $data['status'] = $request->has('status') ? 'on' : 'off';
        
        $baf->update($data);
        
        return redirect()->route('baf.index')->with('success','Images Updated Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}