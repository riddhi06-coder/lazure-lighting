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


class ProjectsController extends Controller
{

    public function index()
    {
        // // Fetch all categories with their projects
        // $categories = ProjectCategory::with(['projects' => function($query) {
        //     $query->orderBy('created_at', 'asc');
        // }])->whereNull('deleted_by')->get();


        $categories = ProjectCategory::with(['projects' => function($query) {
            $query->whereNull('deleted_by')   // Check in projects table
                  ->orderBy('created_at', 'asc');
        }])->whereNull('deleted_by')          // Check in categories table
          ->get();
  
        // dd($categories);
        return view('backend.projects.projects_list.index', compact('categories'));
    }

    public function create(Request $request)
    {
        $projects_category = ProjectCategory::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('backend.projects.projects_list.create', compact('projects_category'));
    }

    public function store(Request $request)
    {
        // ✅ Validate the request
        $validatedData = $request->validate([
            'project_category' => 'required|exists:project_category,id',
            'project_name'     => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'banner_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'project_category.required' => 'Please select a Project Category.',
            'project_category.exists'   => 'Selected Project Category is invalid.',
            'project_name.required'     => 'Please enter the Project Name.',
            'project_name.string'       => 'Project Name must be a valid string.',
            'project_name.max'          => 'Project Name should not exceed 255 characters.',
            'project_location.required' => 'Please enter the Project Location.',
            'project_location.string'   => 'Project Location must be a valid string.',
            'project_location.max'      => 'Project Location should not exceed 255 characters.',
            'banner_image.required'     => 'Please upload a Thumbnail Image.',
            'banner_image.image'        => 'The uploaded file must be an image.',
            'banner_image.mimes'        => 'Thumbnail Image must be jpg, jpeg, png, or webp format.',
            'banner_image.max'          => 'Thumbnail Image must not exceed 2MB.',
        ]);

        // ✅ File Upload Helper
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects/'), $fileName);
            $bannerImagePath = 'uploads/projects/' . $fileName;
        }

        $slug = Str::slug($request->project_name, '-');

        // ✅ Save Project in DB
        $project = new Project();
        $project->category_id     = $request->project_category;
        $project->project_name    = $request->project_name;
        $project->project_location = $request->project_location;
        $project->slug             = $slug;
        $project->thumbnail_image  = $bannerImagePath;
        
        $project->meta_title       = $request->meta_title;
        $project->meta_description = $request->meta_description;
        $project->cannonical       = $request->cannonical;
        $project->hreflang         = $request->hreflang;
        $project->og_tag           = $request->og_tag;
        $project->twitter_card_tag = $request->twitter_card_tag;
        
        
        $project->created_by      = Auth::id();
        $project->created_at      = Carbon::now();
        $project->save();

        // ✅ Redirect with success message
        return redirect()->route('manage-projects.index')->with('message', 'Project added successfully!');
    }
    
    
    public function updateStatus(Request $request, $id)
    {
        $blog = Project::findOrFail($id);
        $blog->status = $request->status; 
        $blog->save();

        return response()->json(['success' => true]);
    }
    

    public function edit($id)
    {
        $projects_list = Project::findOrFail($id);
        // dd($projects_list);
        $projects_category = ProjectCategory::orderBy('created_at', 'asc')->whereNull('deleted_by')->get();
        return view('backend.projects.projects_list.edit', compact('projects_list', 'projects_category'));
    }

    public function update(Request $request, $id)
    {
        // Find the existing project
        $project = Project::findOrFail($id);

        // ✅ Validate the request
        $validatedData = $request->validate([
            'project_category' => 'required|exists:project_category,id',
            'project_name'     => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'project_category.required' => 'Please select a Project Category.',
            'project_category.exists'   => 'Selected Project Category is invalid.',
            'project_name.required'     => 'Please enter the Project Name.',
            'project_name.string'       => 'Project Name must be a valid string.',
            'project_name.max'          => 'Project Name should not exceed 255 characters.',
            'project_location.required' => 'Please enter the Project Location.',
            'project_location.string'   => 'Project Location must be a valid string.',
            'project_location.max'      => 'Project Location should not exceed 255 characters.',
            'banner_image.image'        => 'The uploaded file must be an image.',
            'banner_image.mimes'        => 'Thumbnail Image must be jpg, jpeg, png, or webp format.',
            'banner_image.max'          => 'Thumbnail Image must not exceed 2MB.',
        ]);

        // ✅ Handle file upload if a new image is provided
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($project->thumbnail_image && file_exists(public_path($project->thumbnail_image))) {
                unlink(public_path($project->thumbnail_image));
            }

            $file = $request->file('banner_image');
            $fileName = time() . '_' . rand(1000, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/projects/'), $fileName);
            $project->thumbnail_image = 'uploads/projects/' . $fileName;
        }

        // ✅ Update other fields
        $project->category_id      = $request->project_category;
        $project->project_name     = $request->project_name;
        $project->project_location = $request->project_location;
        
        $project->meta_title       = $request->meta_title;
        $project->meta_description = $request->meta_description;
        $project->cannonical       = $request->cannonical;
        $project->hreflang         = $request->hreflang;
        $project->og_tag           = $request->og_tag;
        $project->twitter_card_tag = $request->twitter_card_tag;
        
        $project->slug             = Str::slug($request->project_name, '-');
        $project->modified_by      = Auth::id();
        $project->modified_at      = Carbon::now();

        $project->save();

        // ✅ Redirect with success message
        return redirect()->route('manage-projects.index')->with('message', 'Project updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Project::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-projects.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}