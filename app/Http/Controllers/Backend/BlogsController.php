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
use App\Models\Blog;


class BlogsController extends Controller
{

    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'asc')->get();
        return view('backend.blog.list.index', compact('blogs'));
    }

    public function create(Request $request)
    {
        return view('backend.blog.list.create');
    }

    public function store(Request $request)
    {
        // Validation Rules
        $rules = [
            'banner_title'   => 'nullable|string|max:255',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'blog_title'     => 'required|string|max:255',
            'blog_date'      => 'required|date',
            'blog_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Custom Messages
        $messages = [
            'banner_title.max'          => 'Banner Title must not exceed 255 characters.',
            'banner_image.image'        => 'Banner Image must be an image file.',
            'banner_image.mimes'        => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for Banner Image.',
            'banner_image.max'          => 'Banner Image must not exceed 2MB.',

            'blog_title.required'       => 'Please enter a Blog Title.',
            'blog_title.max'            => 'Blog Title must not exceed 255 characters.',

            'blog_date.required'        => 'Please select a date.',
            'blog_date.date'            => 'Please enter a valid date.',

            'blog_image.required'       => 'Please upload a Blog Image.',
            'blog_image.image'          => 'Blog Image must be an image file.',
            'blog_image.mimes'          => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for Blog Image.',
            'blog_image.max'            => 'Blog Image must not exceed 2MB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // Generate Slug from blog title
        $slug = Str::slug($request->blog_title);

        // Upload Banner Image if exists
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/blogs/'), $bannerImageName);
            $bannerImagePath = 'uploads/blogs/' . $bannerImageName;
        }

        // Upload Blog Image (Required)
        $blogImagePath = null;
        if ($request->hasFile('blog_image')) {
            $blogImage = $request->file('blog_image');
            $blogImageName = time() . rand(10, 999) . '.' . $blogImage->getClientOriginalExtension();
            $blogImage->move(public_path('uploads/blogs/'), $blogImageName);
            $blogImagePath = 'uploads/blogs/' . $blogImageName;
        }

        // Create Blog
        Blog::create([
            'banner_title'   => $request->banner_title,
            'banner_image'   => $bannerImagePath,
            'blog_title'     => $request->blog_title,
            'slug'           => $slug,
            'blog_date'      => $request->blog_date,
            'blog_image'     => $blogImagePath,
            'created_by'     => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);

        return redirect()->route('manage-blogs.index')->with('message', 'Blog created successfully.');
    }


}