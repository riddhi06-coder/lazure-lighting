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
use App\Models\ProjectCategory;


class ProjectController extends Controller
{

    public function index()
    {
        $projects = ProjectCategory::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('backend.projects.category.index', compact('projects'));
    }

    public function create(Request $request)
    {
        return view('backend.projects.category.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'project_category' => 'required|string|max:255',
            'banner_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ];

        $messages = [
            'project_category.required' => 'Please enter a Projects Category.',
            'project_category.max'      => 'Projects Category must not exceed 255 characters.',

            'banner_image.required'     => 'Please upload a Thumbnail Image.',
            'banner_image.image'        => 'Thumbnail must be an image file.',
            'banner_image.mimes'        => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'banner_image.max'          => 'Thumbnail image must not exceed 2MB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $slug = Str::slug($request->project_category);

        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/projects/'), $bannerImageName);
            $bannerImagePath = 'uploads/projects/' . $bannerImageName;
        }

        ProjectCategory::create([
            'category_name' => $request->project_category,
            'slug'             => $slug,
            'banner_image'     => $bannerImagePath,
            'created_by'       => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);

        return redirect()->route('manage-project-category.index')->with('message', 'Project Category created successfully.');
    }

    public function edit($id)
    {
        $appIntro = ProjectCategory::findOrFail($id);
        return view('backend.projects.category.edit', compact('appIntro'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'project_category' => 'required|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'project_category.required' => 'Please enter a Projects Category.',
            'project_category.max'      => 'Projects Category must not exceed 255 characters.',

            'banner_image.image'        => 'Thumbnail must be an image file.',
            'banner_image.mimes'        => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'banner_image.max'          => 'Thumbnail image must not exceed 2MB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $projectCategory = ProjectCategory::findOrFail($id);

        // Generate slug
        $slug = Str::slug($request->project_category);

        // Handle image upload
        $bannerImagePath = $projectCategory->banner_image;
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($bannerImagePath && file_exists(public_path($bannerImagePath))) {
                unlink(public_path($bannerImagePath));
            }

            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/projects/'), $bannerImageName);
            $bannerImagePath = 'uploads/projects/' . $bannerImageName;
        }

        // Update record
        $projectCategory->update([
            'category_name' => $request->project_category,
            'slug'          => $slug,
            'banner_image'  => $bannerImagePath,
            'modified_by'    => Auth::id(),
            'modified_at'    => Carbon::now(),
        ]);

        return redirect()->route('manage-project-category.index')->with('message', 'Project Category updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ProjectCategory::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-project-category.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}