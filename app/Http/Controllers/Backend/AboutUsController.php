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
use App\Models\AboutUs;


class AboutUsController extends Controller
{

    public function index()
    {
        $AboutUs = AboutUs::whereNull('deleted_by')->get(); 
        return view('backend.about.lazure.index', compact('AboutUs'));
    }

    public function create(Request $request)
    {
        return view('backend.about.lazure.create');
    }

    public function store(Request $request)
    {
        // ✅ Validation rules & messages
        $validated = $request->validate(
            [
                'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            
                // Either video OR youtube url required
                'banner_video'    => 'nullable|mimes:mp4,webm,ogg|max:4096|required_without:youtube_url',
                'youtube_url'     => 'nullable|url|required_without:banner_video',
            
                // Thumbnail required only if video is uploaded
                'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|required_with:banner_video',
            
                'heading'         => 'required|string|max:255',
                'heading_icon'    => 'required|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'image_title'     => 'required|string|max:255',
                'extra_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'description'     => 'required|string',
            ],
            [
                // Video / URL
                'banner_video.required_without' => 'Please upload a video or provide a YouTube URL.',
                'youtube_url.required_without'  => 'Please upload a video or provide a YouTube URL.',
                'youtube_url.url'               => 'Please enter a valid YouTube URL.',
            
                // Thumbnail
                'thumbnail_image.required_with' => 'Thumbnail image is required when a video is uploaded.',


                // Heading
                'heading.required'     => 'The heading field is required.',
                'heading.max'          => 'The heading may not be greater than 255 characters.',

                // Heading Icon
                'heading_icon.required'=> 'The heading icon is required.',
                'heading_icon.image'   => 'The heading icon must be a valid image file.',
                'heading_icon.mimes'   => 'The heading icon must be a file of type: jpg, jpeg, png, webp.',
                'heading_icon.max'     => 'The heading icon may not be greater than 2MB.',

                // Image Title
                'image_title.required' => 'The image title field is required.',
                'image_title.max'      => 'The image title may not be greater than 255 characters.',

                // Extra Image
                'extra_image.required' => 'The extra image is required.',
                'extra_image.image'    => 'The extra image must be a valid image file.',
                'extra_image.mimes'    => 'The extra image must be a file of type: jpg, jpeg, png, webp.',
                'extra_image.max'      => 'The extra image may not be greater than 2MB.',

                // Description
                'description.required' => 'The description field is required.',
            ]
        );


        try {
            // Initialize variables
            $bannerImageName = null;
            $bannerVideoName = null;
            $thumbnailName   = null;
            $headingIconName = null;
            $extraImageName  = null;

            // ✅ Banner Image Upload
            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $bannerImageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/about'), $bannerImageName);
            }

            // ✅ Banner Video Upload
            if ($request->hasFile('banner_video')) {
                $video = $request->file('banner_video');
                $bannerVideoName = time() . rand(1000, 9999) . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('uploads/about'), $bannerVideoName);
            }

            // ✅ Thumbnail Image Upload
            if ($request->hasFile('thumbnail_image')) {
                $thumb = $request->file('thumbnail_image');
                $thumbnailName = time() . rand(10000, 99999) . '.' . $thumb->getClientOriginalExtension();
                $thumb->move(public_path('uploads/about'), $thumbnailName);
            }

            // ✅ Heading Icon Upload
            if ($request->hasFile('heading_icon')) {
                $icon = $request->file('heading_icon');
                $headingIconName = time() . rand(100000, 999999) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('uploads/about'), $headingIconName);
            }

            // ✅ Extra Image Upload
            if ($request->hasFile('extra_image')) {
                $extra = $request->file('extra_image');
                $extraImageName = time() . rand(1000000, 9999999) . '.' . $extra->getClientOriginalExtension();
                $extra->move(public_path('uploads/about'), $extraImageName);
            }

            // ✅ Save in DB (example)
            $about = new AboutUs();
            $about->banner_image    = $bannerImageName;
            $about->banner_video    = $bannerVideoName;
            $about->thumbnail_image = $thumbnailName;
            $about->heading         = $validated['heading'];
            $about->youtube_url     = $validated['youtube_url'];
            $about->heading_icon    = $headingIconName;
            $about->image_title     = $validated['image_title'];
            $about->extra_image     = $extraImageName;
            $about->description     = $validated['description'];
            $about->created_at      = Carbon::now(); 
            $about->created_by      = Auth::user()->id;
            $about->save();

            return redirect()->route('manage-about-us.index')->with('message', 'About Us details saved successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $AboutUs = AboutUs::findOrFail($id);
        return view('backend.about.lazure.edit', compact('AboutUs'));
    }

    public function update(Request $request, $id)
    {
        $about = AboutUs::findOrFail($id);

        // ✅ Validation rules & messages
        $validated = $request->validate(
            [
                'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            
                // Either Video or Youtube URL required
                'banner_video'    => 'nullable|mimes:mp4,webm,ogg|max:4096|required_without:youtube_url',
                'youtube_url'     => 'nullable|url|required_without:banner_video',
            
                // Thumbnail required only if video is uploaded
                'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|required_with:banner_video',
            
                'heading'         => 'required|string|max:255',
                'heading_icon'    => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'image_title'     => 'required|string|max:255',
                'extra_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'description'     => 'required|string',
            ],
            [
                // Banner Image
                'banner_image.image'   => 'The banner image must be a valid image file.',
                'banner_image.mimes'   => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
                'banner_image.max'     => 'The banner image may not be greater than 2MB.',
            
                // Banner Video / Youtube
                'banner_video.mimes'   => 'The banner video must be a file of type: mp4, webm, ogg.',
                'banner_video.max'     => 'The banner video may not be greater than 4MB.',
                'banner_video.required_without' => 'Please upload a video or provide a YouTube URL.',
            
                'youtube_url.required_without'  => 'Please upload a video or provide a YouTube URL.',
                'youtube_url.url'               => 'Please enter a valid YouTube URL.',
            
                // Thumbnail Image
                'thumbnail_image.image' => 'The thumbnail image must be a valid image file.',
                'thumbnail_image.mimes' => 'The thumbnail image must be a file of type: jpg, jpeg, png, webp.',
                'thumbnail_image.max'   => 'The thumbnail image may not be greater than 2MB.',
                'thumbnail_image.required_with' => 'Thumbnail image is required when a video is uploaded.',
            
                // Heading
                'heading.required'     => 'The heading field is required.',
                'heading.max'          => 'The heading may not be greater than 255 characters.',
            
                // Heading Icon
                'heading_icon.mimes'   => 'The heading icon must be a file of type: jpg, jpeg, png, webp, svg.',
                'heading_icon.max'     => 'The heading icon may not be greater than 2MB.',
            
                // Image Title
                'image_title.required' => 'The image title field is required.',
                'image_title.max'      => 'The image title may not be greater than 255 characters.',
            
                // Extra Image
                'extra_image.image'    => 'The extra image must be a valid image file.',
                'extra_image.mimes'    => 'The extra image must be a file of type: jpg, jpeg, png, webp.',
                'extra_image.max'      => 'The extra image may not be greater than 2MB.',
            
                // Description
                'description.required' => 'The description field is required.',
            ]);


        try {
            // Banner Image
            if ($request->hasFile('banner_image')) {
                // Delete old file if exists
                if ($about->banner_image && file_exists(public_path('uploads/about/'.$about->banner_image))) {
                    unlink(public_path('uploads/about/'.$about->banner_image));
                }
                $image = $request->file('banner_image');
                $about->banner_image = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/about'), $about->banner_image);
            }

            // Banner Video
            if ($request->hasFile('banner_video')) {
                if ($about->banner_video && file_exists(public_path('uploads/about/'.$about->banner_video))) {
                    unlink(public_path('uploads/about/'.$about->banner_video));
                }
                $video = $request->file('banner_video');
                $about->banner_video = time() . rand(1000, 9999) . '.' . $video->getClientOriginalExtension();
                $video->move(public_path('uploads/about'), $about->banner_video);
            }

            // Thumbnail Image
            if ($request->hasFile('thumbnail_image')) {
                if ($about->thumbnail_image && file_exists(public_path('uploads/about/'.$about->thumbnail_image))) {
                    unlink(public_path('uploads/about/'.$about->thumbnail_image));
                }
                $thumb = $request->file('thumbnail_image');
                $about->thumbnail_image = time() . rand(10000, 99999) . '.' . $thumb->getClientOriginalExtension();
                $thumb->move(public_path('uploads/about'), $about->thumbnail_image);
            }

            // Heading Icon
            if ($request->hasFile('heading_icon')) {
                if ($about->heading_icon && file_exists(public_path('uploads/about/'.$about->heading_icon))) {
                    unlink(public_path('uploads/about/'.$about->heading_icon));
                }
                $icon = $request->file('heading_icon');
                $about->heading_icon = time() . rand(100000, 999999) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('uploads/about'), $about->heading_icon);
            }

            // Extra Image
            if ($request->hasFile('extra_image')) {
                if ($about->extra_image && file_exists(public_path('uploads/about/'.$about->extra_image))) {
                    unlink(public_path('uploads/about/'.$about->extra_image));
                }
                $extra = $request->file('extra_image');
                $about->extra_image = time() . rand(1000000, 9999999) . '.' . $extra->getClientOriginalExtension();
                $extra->move(public_path('uploads/about'), $about->extra_image);
            }

            // Other fields
            $about->heading     = $validated['heading'];
            $about->image_title = $validated['image_title'];
            $about->description = $validated['description'];
            $about->youtube_url = $validated['youtube_url'];
            $about->modified_at  = Carbon::now();
            $about->modified_by  = Auth::user()->id;

            $about->save();

            return redirect()->route('manage-about-us.index')->with('message', 'About Us details updated successfully');

        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = AboutUs::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-about-us.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}