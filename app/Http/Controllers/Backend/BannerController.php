<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Banner;



class BannerController extends Controller
{

    public function index()
    {
        $banner = Banner::whereNull('deleted_by')->get(); 
        return view('backend.home.banner.index', compact('banner'));
    }
    

    public function create(Request $request)
    { 
        return view('backend.home.banner.create');
    }

    public function store(Request $request)
    {
        // Custom validation: either image or video is required
        if (!$request->hasFile('banner_image') && !$request->hasFile('banner_video')) {
            return back()->withErrors([
                'banner_image' => 'Please upload either a Banner Image or a Banner Video.',
                'banner_video' => 'Please upload either a Banner Image or a Banner Video.',
            ])->withInput();
        }
    
        // Both uploaded → NOT allowed
        if ($request->hasFile('banner_image') && $request->hasFile('banner_video')) {
            return back()->withErrors([
                'banner_image' => 'Please upload only one file: either Image OR Video.',
                'banner_video' => 'Please upload only one file: either Image OR Video.',
            ])->withInput();
        }
    
        // Base validation (common fields)
        $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_title' => 'required|string|max:255',
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_title.required' => 'The banner title is required.',
        ]);
    
        // Validate image or video separately
        if ($request->hasFile('banner_image')) {
            $request->validate([
                'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:3072', // 3MB
            ], [
                'banner_image.required' => 'The banner image is required.',
                'banner_image.image' => 'The uploaded file must be an image.',
                'banner_image.mimes' => 'Only JPG, JPEG, PNG, WEBP formats are allowed.',
                'banner_image.max' => 'The banner image must not be greater than 3MB.',
            ]);
        } elseif ($request->hasFile('banner_video')) {
            $request->validate([
                'banner_video' => 'required|mimetypes:video/mp4,video/avi,video/mov,video/webm|max:5000', 
            ], [
                'banner_video.required' => 'The banner video is required.',
                'banner_video.mimetypes' => 'Allowed formats: mp4, avi, mov, webm.',
                'banner_video.max' => 'The banner video must not be greater than 50MB.',
            ]);
        }
    
        // Save File
        $imageName = null;
        $videoName = null;
    
        // Handle image upload
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/home/banner'), $imageName);
        }
    
        // Handle video upload
        if ($request->hasFile('banner_video')) {
            $video = $request->file('banner_video');
            $videoName = time() . rand(10, 999) . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads/home/banner'), $videoName);
        }
    
        // Save to Database
        $banner = new Banner();
        $banner->banner_heading = $request->banner_heading;
        $banner->banner_title = $request->banner_title;
        $banner->banner_images = $imageName;  
        $banner->banner_video = $videoName;  
        $banner->created_by = Auth::user()->id;
        $banner->created_at = now();
        $banner->save();
    
        return redirect()->route('manage-banner.index')->with('message', 'Banner has been successfully added!');
    }

    public function edit($id)
    {
        $banner_details = Banner::findOrFail($id);
        return view('backend.home.banner.edit', compact('banner_details'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'nullable|mimes:jpg,jpeg,png,webp|max:3072',
            'banner_video' => 'nullable|mimes:mp4,mov,avi,wmv,webm|max:5000', // 5MB
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_title.required' => 'The banner title is required.',
            'banner_image.max' => 'The banner image must not be greater than 3MB.',
            'banner_video.mimes' => 'Only MP4, MOV, AVI, WMV, WEBM formats are allowed for video.',
            'banner_video.max' => 'The banner video must not be greater than 50MB.',
        ]);
    
        // Fetch existing record
        $banner = Banner::findOrFail($id);
    
        // -------------------------------
        // Validate Either Image OR Video
        // -------------------------------
        if (!$request->hasFile('banner_image') && !$request->hasFile('banner_video') &&
            !$banner->banner_images && !$banner->banner_video) 
        {
            return back()->withErrors([
                'banner_image' => 'Either Banner Image or Banner Video is required.',
                'banner_video' => 'Either Banner Video or Banner Image is required.',
            ])->withInput();
        }
    
        if ($request->hasFile('banner_image') && $request->hasFile('banner_video')) {
            return back()->withErrors([
                'banner_image' => 'You can upload either Banner Image or Banner Video, not both.',
                'banner_video' => 'You can upload either Banner Video or Banner Image, not both.',
            ])->withInput();
        }
    
        // -------------------------------
        // Handle Image Upload
        // -------------------------------
        $imageName = $banner->banner_images;
    
        if ($request->hasFile('banner_image')) {
    
            // Delete Old Image if exists
            if ($banner->banner_images && file_exists(public_path('uploads/home/banner/' . $banner->banner_images))) {
                unlink(public_path('uploads/home/banner/' . $banner->banner_images));
            }
    
            // Upload new image
            $image = $request->file('banner_image');
            $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/home/banner'), $imageName);
    
            // If image uploaded, remove old video
            if ($banner->banner_video && file_exists(public_path('uploads/home/banner/' . $banner->banner_video))) {
                unlink(public_path('uploads/home/banner/' . $banner->banner_video));
            }
    
            $banner->banner_video = null;
        }
    
        // -------------------------------
        // Handle Video Upload
        // -------------------------------
        $videoName = $banner->banner_video;
    
        if ($request->hasFile('banner_video')) {
    
            // Delete Old Video if exists
            if ($banner->banner_video && file_exists(public_path('uploads/home/banner/' . $banner->banner_video))) {
                unlink(public_path('uploads/home/banner/' . $banner->banner_video));
            }
    
            // Upload new video
            $video = $request->file('banner_video');
            $videoName = time() . rand(10, 999) . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('/uploads/home/banner'), $videoName);
    
            // If video uploaded, remove old image
            if ($banner->banner_images && file_exists(public_path('uploads/home/banner/' . $banner->banner_images))) {
                unlink(public_path('uploads/home/banner/' . $banner->banner_images));
            }
    
            $banner->banner_images = null;
        }
    
        // -------------------------------
        // Save Updated Data
        // -------------------------------
        $banner->banner_heading = $request->input('banner_heading');
        $banner->banner_title = $request->input('banner_title');
        $banner->banner_images = $imageName;
        $banner->banner_video = $videoName;
        $banner->modified_at = Carbon::now();
        $banner->modified_by = Auth::user()->id;
        $banner->save();
    
        return redirect()->route('manage-banner.index')->with('message', 'Banner has been successfully updated!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Banner::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-banner.index')->with('message', 'Banner Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
    
    public function updatePriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|numeric|min:0'
        ]);
    
        // Check if another banner already has this priority
        $existing = Banner::where('priority', $request->priority)
                          ->where('id', '!=', $id) // exclude current
                          ->whereNull('deleted_by')
                          ->first();
    
        if ($existing) {
            return redirect()->route('manage-banner.index')->with('message', 'This priority is already assigned to another banner.');
        }
    
        // Update priority
        $banner = Banner::findOrFail($id);
        $banner->priority = $request->priority;
        $banner->save();
    
        return redirect()->route('manage-banner.index')->with('message', 'Priority updated successfully!');
    }


}