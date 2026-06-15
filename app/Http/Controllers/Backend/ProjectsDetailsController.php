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
use App\Models\ProjectCategory;
use App\Models\ProjectsDetails;


class ProjectsDetailsController extends Controller
{

    public function index()
    {
        $projectsDetails = ProjectsDetails::with('project')->wherenull('deleted_by')->get();
        // dd($projectsDetails);
        return view('backend.projects.projects_details.index', compact('projectsDetails'));
    }

    public function create(Request $request)
    {
        $projects_category = ProjectCategory::orderBy('created_at', 'asc')
                                        ->whereNull('deleted_by')
                                        ->get();

        $projects = Project::orderBy('created_at', 'asc')
                        ->whereNull('deleted_by')
                        ->get();

        return view('backend.projects.projects_details.create', compact('projects_category', 'projects'));
    }

    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'project_name'        => 'required|exists:projects,id|unique:project_details,project_id',
            'project_category'    => 'required|exists:project_category,id',
            'banner_image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_title'       => 'required|string|max:255',
            'project_description' => 'required|string',
            'section_title'       => 'required|string|max:255',
            'highlights.*'        => 'required|string|max:255',
            'gallery_images.*'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            
            'project_name.unique' => 'This project already has details entered.',
            'project_name.required'        => 'Please select a Project.',
            'project_category.required'    => 'Project Category is required.',
            'banner_image.required'        => 'Please upload a Banner Image.',
            'project_image.required'       => 'Please upload a Project Image.',
            'project_title.required'       => 'Please enter Project Title.',
            'project_description.required' => 'Please enter Project Description.',
            'section_title.required'       => 'Please enter Section Title.',
            'highlights.*.required'        => 'Please enter all Highlight Features.',
            'gallery_images.*.required'    => 'Please upload all Gallery Images.',
        ]);

        // Upload Banner Image
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects/'), $fileName);
            $bannerImagePath = 'uploads/projects/' . $fileName;
        }

        // Upload Project Image
        $projectImagePath = null;
        if ($request->hasFile('project_image')) {
            $file = $request->file('project_image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects/'), $fileName);
            $projectImagePath = 'uploads/projects/' . $fileName;
        }

        // Upload Gallery Images
        $galleryPaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/projects/'), $fileName);
                $galleryPaths[] = 'uploads/projects/' . $fileName;
            }
        }

        // Encode Highlights and Gallery as JSON
        $highlightsJson = $request->has('highlights') ? json_encode($request->highlights) : null;
        $galleryJson = !empty($galleryPaths) ? json_encode($galleryPaths) : null;

        // Save to DB
        $projectDetails = new ProjectsDetails();
        $projectDetails->project_id = $request->project_name;
        $projectDetails->category_id = $request->project_category;
        $projectDetails->banner_image = $bannerImagePath;
        $projectDetails->project_image = $projectImagePath;
        $projectDetails->project_title = $request->project_title;
        $projectDetails->project_description = $request->project_description;
        $projectDetails->section_title = $request->section_title;
        $projectDetails->highlights = $highlightsJson;
        $projectDetails->gallery_images = $galleryJson;
        $projectDetails->created_by = Auth::id();
        $projectDetails->created_at = Carbon::now();

        $projectDetails->save();

        return redirect()->route('manage-projects-details.index')
            ->with('message', 'Project Details added successfully.');
    }

    public function edit($id)
    {
        $projects_list = ProjectsDetails::findOrFail($id);
        $projects_category = ProjectCategory::orderBy('created_at', 'asc')
            ->whereNull('deleted_by')
            ->get();
        $projects = Project::orderBy('created_at', 'asc')
            ->whereNull('deleted_by')
            ->get();

        return view('backend.projects.projects_details.edit', compact('projects_list', 'projects_category', 'projects'));
    }


    public function update(Request $request, $id)
    {
        // Find the existing project details
        $projectDetails = ProjectsDetails::findOrFail($id);

        // Validation
        $validatedData = $request->validate([
            'project_name'        => 'required|exists:projects,id|unique:project_details,project_id,' . $id,
            'project_category'    => 'required|exists:project_category,id',
            'banner_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_title'       => 'required|string|max:255',
            'project_description' => 'required|string',
            'section_title'       => 'required|string|max:255',
            'highlights.*'        => 'required|string|max:255',
            'gallery_images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'project_name.unique' => 'This project already has details entered.',
            'project_name.required'        => 'Please select a Project.',
            'project_category.required'    => 'Project Category is required.',
            'banner_image.required'        => 'Please upload a Banner Image.',
            'project_image.required'       => 'Please upload a Project Image.',
            'project_title.required'       => 'Please enter Project Title.',
            'project_description.required' => 'Please enter Project Description.',
            'section_title.required'       => 'Please enter Section Title.',
            'highlights.*.required'        => 'Please enter all Highlight Features.',
            'gallery_images.*.required'    => 'Please upload all Gallery Images.',
        ]);

        // Banner Image upload (if new)
        if ($request->hasFile('banner_image')) {
            if ($projectDetails->banner_image && file_exists(public_path($projectDetails->banner_image))) {
                unlink(public_path($projectDetails->banner_image));
            }
            $file = $request->file('banner_image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects/'), $fileName);
            $projectDetails->banner_image = 'uploads/projects/' . $fileName;
        }

        // Project Image upload (if new)
        if ($request->hasFile('project_image')) {
            if ($projectDetails->project_image && file_exists(public_path($projectDetails->project_image))) {
                unlink(public_path($projectDetails->project_image));
            }
            $file = $request->file('project_image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects/'), $fileName);
            $projectDetails->project_image = 'uploads/projects/' . $fileName;
        }

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
        $projectDetails->highlights = json_encode($request->highlights);


        // Update other fields
        $projectDetails->project_id = $request->project_name;
        $projectDetails->category_id = $request->project_category;
        $projectDetails->project_title = $request->project_title;
        $projectDetails->project_description = $request->project_description;
        $projectDetails->section_title = $request->section_title;
        $projectDetails->modified_by = Auth::id();
        $projectDetails->modified_at = Carbon::now();

        $projectDetails->save();

        return redirect()->route('manage-projects-details.index')
            ->with('message', 'Project Details updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ProjectsDetails::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-projects-details.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}