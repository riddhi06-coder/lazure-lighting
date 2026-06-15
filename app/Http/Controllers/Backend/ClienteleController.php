<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\Clientele;


class ClienteleController extends Controller
{

    public function index()
    {
        $projectsDetails = Clientele::wherenull('deleted_by')->get();
        
        return view('backend.home.clientele.index', compact('projectsDetails'));
    }

    public function create(Request $request)
    {
        return view('backend.home.clientele.create');
    }
    
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'gallery_images.*'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [

            'gallery_images.*.required'    => 'Please upload all Gallery Images.',
        ]);


        // Upload Gallery Images
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/home/'), $fileName);
                $galleryPaths[] = 'uploads/home/' . $fileName;
            }
        }

        // Encode Highlights and Gallery as JSON
        $highlightsJson = $request->has('highlights') ? json_encode($request->highlights) : null;
        $galleryJson = !empty($galleryPaths) ? json_encode($galleryPaths) : null;

        // Save to DB
        $projectDetails = new Clientele();
        $projectDetails->gallery_images = $galleryJson;
        $projectDetails->created_by = Auth::id();
        $projectDetails->created_at = Carbon::now();

        $projectDetails->save();

        return redirect()->route('manage-clientele.index')
            ->with('message', 'Our Clientele added successfully.');
    }
    
    public function edit($id)
    {
        $projects_list = Clientele::findOrFail($id);
        return view('backend.home.clientele.edit', compact('projects_list'));
    }
    
    public function update(Request $request, $id)
    {
        // Find the existing project details
        $projectDetails = Clientele::findOrFail($id);

        // Validation
        $validatedData = $request->validate([
            'gallery_images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'gallery_images.*.required'    => 'Please upload all Gallery Images.',
        ]);


        // Gallery Images upload (if new files)
        $existingImages = $request->input('existing_gallery_images', []); // array of remaining images

        $galleryPaths = $existingImages; // start with remaining existing images

        // Add new uploaded images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/projects/'), $fileName);
                $galleryPaths[] = 'uploads/projects/' . $fileName;
            }
        }


        $projectDetails->gallery_images = !empty($galleryPaths) ? json_encode($galleryPaths) : null;



        // Update other fields
        $projectDetails->modified_by = Auth::id();
        $projectDetails->modified_at = Carbon::now();

        $projectDetails->save();

        return redirect()->route('manage-clientele.index')
            ->with('message', 'Details updated successfully.');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Clientele::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-clientele.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}