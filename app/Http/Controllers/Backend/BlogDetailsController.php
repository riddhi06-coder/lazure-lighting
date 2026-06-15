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
use App\Models\BlogDetails;


class BlogDetailsController extends Controller
{

    public function index()
    {
        $blogs = BlogDetails::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('backend.blog.details.index', compact('blogs'));
    }

    public function create(Request $request)
    {
        $blogs = Blog::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('backend.blog.details.create', compact('blogs'));
    }
    
    public function store(Request $request)
    {
        // ================= Validation =================
        $request->validate([
            'existing_blog' => 'required|exists:blogs,id',
            'banner_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // max 2MB
            'blog_heading'  => 'required|string',
            'blog_content'  => 'required|string',
        ], [
            'existing_blog.required' => 'Please select a blog.',
            'existing_blog.exists'   => 'Selected blog does not exist.',
            'banner_image.required'  => 'Please upload a banner image.',
            'banner_image.image'     => 'The banner must be an image.',
            'banner_image.mimes'     => 'Only jpg, jpeg, png, webp images are allowed.',
            'banner_image.max'       => 'Image size must be less than 2MB.',
            'blog_content.required'  => 'Please enter the blog content.',
            'blog_heading.required'  => 'Please enter the blog heading.',
        ]);
    
        // ================= Upload Banner Image =================
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/blogs/'), $bannerImageName);
            $bannerImagePath = 'uploads/blogs/' . $bannerImageName;
        }
    
        // ================= Store Blog Details =================
        $blogDetail = new BlogDetails(); // Assuming model name is BlogDetail
        $blogDetail->blog_id      = $request->existing_blog;
        $blogDetail->banner_image = $bannerImagePath;
        $blogDetail->blog_heading = $request->blog_heading;
        $blogDetail->blog_content = $request->blog_content;
        $blogDetail->created_by   = Auth::id();
        $blogDetail->created_at   = Carbon::now();
        $blogDetail->save();
    
        return redirect()->route('manage-blog-details.index')->with('message', 'Blog details added successfully!');
    }
    
    public function edit($id)
    {
        $blog = BlogDetails::findOrFail($id);
        $blogs = Blog::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('backend.blog.details.edit', compact('blog','blogs'));
    }
    
    public function update(Request $request, $id)
    {
        // Fetch the existing blog detail
        $blogDetail = BlogDetails::findOrFail($id);
    
        // ================= Validation =================
        $request->validate([
            'existing_blog' => 'required|exists:blogs,id',
            'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // optional
             'blog_heading'  => 'required|string',
            'blog_content'  => 'required|string',
        ], [
            'existing_blog.required' => 'Please select a blog.',
            'existing_blog.exists'   => 'Selected blog does not exist.',
            'banner_image.image'     => 'The banner must be an image.',
            'banner_image.mimes'     => 'Only jpg, jpeg, png, webp images are allowed.',
            'banner_image.max'       => 'Image size must be less than 2MB.',
            'blog_content.required'  => 'Please enter the blog content.',
            'blog_heading.required'  => 'Please enter the blog heading.',
        ]);
    
        // ================= Upload Banner Image if exists =================
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/blogs/'), $bannerImageName);
            $blogDetail->banner_image = 'uploads/blogs/' . $bannerImageName;
        }
    
        // ================= Update Blog Details =================
        $blogDetail->blog_id      = $request->existing_blog;
        $blogDetail->blog_content = $request->blog_content;
        $blogDetail->blog_heading = $request->blog_heading;
        $blogDetail->modified_by   = Auth::id();
        $blogDetail->modified_at   = Carbon::now();
        $blogDetail->save();
    
        return redirect()->route('manage-blog-details.index')->with('message', 'Blog details updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = BlogDetails::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-blog-details.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}