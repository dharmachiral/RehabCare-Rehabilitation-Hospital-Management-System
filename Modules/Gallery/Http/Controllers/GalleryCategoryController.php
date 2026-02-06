<?php

namespace Modules\Gallery\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\GalleryCategory;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $categories = GalleryCategory::all();
        return view('gallery::category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('gallery::category.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $imageName = '';
         if ($request->image)
         {
             $imageName = time().'.'.$request->image->extension();
 
             $request->image->move(public_path('upload/images/gallery'), $imageName);
 
         }
         GalleryCategory::create([
             'title' => $request['title'],
             'status' => $request['status'],
             'image' => $imageName
         ]);
         return back()->with('success', 'Category Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gallery::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('gallery::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $category = GalleryCategory::findOrfail($id);
        $imageName = $category->image;
         if ($request->image)
         {
             $imageName = time().'.'.$request->image->extension();
 
             $request->image->move(public_path('upload/images/gallery'), $imageName);
 
         }
         $category->update([
             'title' => $request['title'],
             'status' => $request['status'],
             'image' => $imageName
         ]);
         return back()->with('success', 'Category Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $category = GalleryCategory::findOrfail($id);
        $category->delete();
        return back()->with('success','Category Deleted Successfully');
    }
    public function status($id)
    {
        $category = GalleryCategory::findOrfail($id);
        if($category->status == 'on')
        {
            $status = 'off';
        }else{
            $status = 'on';
        }
        $category->update([
           'status' => $status 
        ]);
        return back()->with('success','Category Updated Successfully');
    }
}
