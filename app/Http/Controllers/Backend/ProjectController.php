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

}