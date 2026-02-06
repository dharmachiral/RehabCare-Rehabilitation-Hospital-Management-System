<?php

namespace Modules\Gallery\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Entities\GalleryCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        abort_if(Gate::denies('show_galleries'), 403);
        $galleries = Gallery::with('category')->get();
        $categories = GalleryCategory::all();
        return view('gallery::gallery.index', compact('galleries','categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        abort_if(Gate::denies('create_galleries'), 403);
        return view('gallery::gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('create_galleries'), 403);
        $status = $request->has('status') ? 'on' : 'off';

        // Initialize an array to hold image paths
        $imagePaths = [];

        // Loop through each uploaded file and move to folder
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Generate a unique name and move the file to the specified directory
                $uniqueFileName = Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = 'gallery/' . $uniqueFileName;

                // Move file to the target folder within public directory
                $file->move(public_path('gallery'), $uniqueFileName);

                // Store the file path
                $imagePaths[] = $filePath;
            }
        }

        // Save each image as a gallery entry
        foreach ($imagePaths as $imagePath) {
            Gallery::create([
                'title' => $request->input('title'),
                'gallerycategory_id' => $request->input('category'),
                'image' => $imagePath,
                'status' => $status
            ]);
        }
        return back()->with('success','Gallery Added Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gallery::gallery.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        abort_if(Gate::denies('edit_galleries'), 403);
        return view('gallery::gallery.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('delete_galleries'), 403);
        $gallery = Gallery::findOrfail($id);
        $gallery->delete();
        return back()->with('success','Gallery Deleted Successfully');
    }
    public function status($id)
    {
        $gallery = Gallery::findOrfail($id);
        if($gallery->status == 'on')
        {
            $status = 'off';
        }else{
            $status = 'on';
        }
        $gallery->update([
           'status' => $status
        ]);
        return back()->with('success','Gallery Updated Successfully');
    }
    // GalleryController.php
public function showCategoryGalleries($id)
{
    $category = GalleryCategory::with('galleries')->findOrFail($id);
    return response()->json($category->galleries);
}

}
