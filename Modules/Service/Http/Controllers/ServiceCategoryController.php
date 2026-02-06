<?php

namespace Modules\Service\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Service\Entities\ServiceCategory;
use Modules\Service\Http\Requests\ServiceCategoryStoreRequest;
use Illuminate\Support\Str;
use Modules\Service\Entities\ProgramCategory;
use Modules\Service\Http\Requests\ServiceCategoryUpdateRequest;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
         abort_if(Gate::denies('show_service_category'), 403);
        $categories = ProgramCategory::get();
        return view('service::category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_service_category'), 403);
        return view('service::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(ServiceCategoryStoreRequest $request)
    {
        abort_if(Gate::denies('create_service_category'), 403);
        $imageName = 'N/A';
        if($request['icon'])
        {
            $imageName = time().'.'.$request->icon->extension();

            $request->icon->move(public_path('upload/images/category'), $imageName);
        }
        $image = 'N/A';
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/category'), $image);
        }
        $slug = Str::slug($request->title);
        ProgramCategory::create([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $imageName,
            'image' => $image,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->route('programs_category.index')->with('success','Category Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        return view('service::category.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_service_category'), 403);
        $serviceCategory = ProgramCategory::findOrfail($id);
        return view('service::category.edit',compact('serviceCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(ServiceCategoryUpdateRequest $request, $id)
    {
        abort_if(Gate::denies('edit_service_category'), 403);
        $category = ProgramCategory::findOrFail($id);
        if($request['icon'])
        {
            $imageName = time().'.'.$request->icon->extension();

            $request->icon->move(public_path('upload/images/category'), $imageName);
        }else{
            $imageName = $category->icon;
        }
        if($request->image)
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('upload/images/category'), $image);
        }else
        {
            $image = $category->image;
        }
        if($request->title)
        {
            $slug = Str::slug($request->title);
        }else{
            $slug = Str::slug($category->title);
        }
        $category->update([
            'title' => $request->title,
            'slug' => $slug,
            'icon' => $imageName,
            'image' => $image,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'status' => $request->status
        ]);
        return redirect()->route('programs_category.index')->with('success','Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_service_category'), 403);
        // abort_if(Gate::denies('delete_service_category'),403);
        $category = ProgramCategory::findOrfail($id);
        $category->delete();
        return back()->with('success','Service Catgory Deleted successfully');
    }
    public function Status($id)
    {
        $service= ProgramCategory::findOrfail($id);
        if($service->status == 'on')
        {
            $status ='off';
        }else{
            $status ='on';
        }
        $service->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success','Program Updated!');
    }
}
