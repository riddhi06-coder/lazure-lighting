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
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Models\BuiltToSuitGallery;


class BuiltToSuitGalleryController extends Controller
{

    public function index()
    {
        $galleries = BuiltToSuitGallery::wherenull('deleted_by')->orderBy('id', 'asc')->get();
        return view('backend.built_to_suit.gallery.index', compact('galleries'));
    }

    public function create(Request $request)
    {
        $hasRecord = BuiltToSuitGallery::whereNull('deleted_by')->exists();
        return view('backend.built_to_suit.gallery.create', compact('hasRecord'));
    }

    
    public function store(Request $request)
    {
        // ✔ Validate Inputs
        $validatedData = $request->validate([
            'banner_heading'       => 'nullable|string|max:255',
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_name'        => 'required|string|max:255',
            'thumbnail_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    
            'gallery_images'      => 'required|array|min:1',
            'gallery_images.*'    => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ], [
            'banner_image.mimes'           => 'Banner image must be jpg, jpeg, png or webp.',
            'project_name.required'      => 'Project name is required.',
            'thumbnail_image.required'   => 'Please upload a thumbnail image.',
            'thumbnail_image.mimes'      => 'Thumbnail must be jpg, jpeg, png or webp.',
    
            'gallery_images.required'    => 'Please upload at least one gallery image.',
            'gallery_images.*.mimes'     => 'Gallery image must be jpg, jpeg, png, webp or svg.',
            'gallery_images.*.max'       => 'Each gallery image must be less than 2MB.',
        ]);
    
        // ✔ File Upload Helper
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/gallery_built/$folder/"), $fileName);
            return "uploads/gallery_built/$folder/" . $fileName;
        };
    
    
        $bannerImagePath = $request->hasFile('banner_image') 
            ? $uploadFile($request->file('banner_image'), 'banner') 
            : null;

        // ✔ Upload Thumbnail Image
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailPath = $uploadFile($request->file('thumbnail_image'), 'thumbnail');
        }
    
        // ✔ Upload Gallery Images (JSON)
        $galleryImages = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryImages[] = $uploadFile($file, 'gallery');
            }
        }
        
        
        // ✔ Generate Unique Slug
        $slug = Str::slug($request->project_name);
    
        // If slug exists, append number
        $existingCount = BuiltToSuitGallery::where('slug', 'LIKE', "{$slug}%")->count();
        if ($existingCount > 0) {
            $slug .= '-' . ($existingCount + 1);
        }
    
        // ✔ Save Data to DB
        $gallery = new BuiltToSuitGallery();
        $gallery->banner_heading   = $request->banner_heading;
        $gallery->banner_image     = $bannerImagePath;
        $gallery->project_name     = $request->project_name;
        $gallery->slug             = $slug;  // ✔ Add slug
        $gallery->thumbnail_image  = $thumbnailPath;
        $gallery->gallery_images   = json_encode($galleryImages, JSON_UNESCAPED_UNICODE);
        $gallery->inserted_by      = Auth::id();
        $gallery->inserted_at      = Carbon::now();
        $gallery->save();
    
        return redirect()->route('manage-gallery-built.index')->with('message', 'Gallery Built project created successfully!');
    }
    
    public function updatePriority(Request $request, $id)
    {
        $request->validate([
            'priority' => 'required|numeric|min:0'
        ]);
    
        // Prevent duplicate priority
        if (BuiltToSuitGallery::where('priority', $request->priority)->where('id', '!=', $id)->exists()) {
            return redirect()->route('manage-gallery-built.index')->with('error', 'Priority already assigned to another project!');
        }
    
        $gallery = BuiltToSuitGallery::findOrFail($id);
        $gallery->priority = $request->priority;
        $gallery->save();
    
        return redirect()->route('manage-gallery-built.index')->with('message', 'Priority updated successfully!');
    }

    
    public function edit($id)
    {
        $built_to_suit = BuiltToSuitGallery::findOrFail($id);
        $isFirstRecord = ($id == 1);
        return view('backend.built_to_suit.gallery.edit', compact('built_to_suit','isFirstRecord'));
    }
    
    public function update(Request $request, $id)
    {
        $built = BuiltToSuitGallery::findOrFail($id);
    
        // -------------------- VALIDATION --------------------
        $validated = $request->validate([
            'banner_heading'       => 'nullable|string|max:255',
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'project_name'      => 'required|string|max:255',
            'thumbnail_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*'  => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);
    
        // -------------------- HELPER FUNCTION --------------------
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/built_to_suit/gallery/"), $fileName);
            return "uploads/built_to_suit/gallery/" . $fileName;
        };
        
        
          // âœ… Upload / Keep old files
        $bannerImagePath = $request->hasFile('banner_image')
            ? $uploadFile($request->file('banner_image'), 'banner')
            : $built->banner_image;

    
        // -------------------- UPDATE THUMBNAIL --------------------
        $thumbnailPath = $built->thumbnail_image;
    
        if ($request->hasFile('thumbnail_image')) {
    
            // delete old image
            if ($thumbnailPath && file_exists(public_path($thumbnailPath))) {
                unlink(public_path($thumbnailPath));
            }
    
            $thumbnailPath = $uploadFile($request->file('thumbnail_image'), 'thumbnail');
        }
    
        // -------------------- HANDLE GALLERY --------------------
    
        // Old gallery images from DB
        // $oldGallery = json_decode($built->gallery_images, true) ?? [];
    
        // // Still existing images (coming from hidden inputs)
        // $newGallery = $request->existing_gallery ?? [];
    
        // // Identify images that were removed in UI → delete from server
        // $imagesToDelete = array_diff($oldGallery, $newGallery);
    
        // foreach ($imagesToDelete as $deleteImg) {
        //     if (file_exists(public_path($deleteImg))) {
        //         unlink(public_path($deleteImg));
        //     }
        // }
    
        // // Append new uploaded images
        // if ($request->hasFile('gallery_images')) {
        //     foreach ($request->file('gallery_images') as $imgFile) {
        //         if ($imgFile->isValid()) {
        //             $newGallery[] = $uploadFile($imgFile, 'gallery');
        //         }
        //     }
        // }
        
        
        $oldGallery = json_decode($built->gallery_images, true) ?? [];
        $existingGallery = $request->existing_gallery ?? [];
        $newGallery = [];
        
        // Loop through existing gallery indexes
        foreach ($existingGallery as $index => $oldImage) {
        
            // If a new file is uploaded at same index → replace
            if ($request->hasFile("gallery_images.$index")) {
        
                // delete old image
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
        
                $newGallery[] = $uploadFile($request->file("gallery_images.$index"), 'gallery');
            }
            // No new file → keep old image
            else {
                $newGallery[] = $oldImage;
            }
        }
        
        // Handle newly added images (indexes not present in existing_gallery)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                if (!isset($existingGallery[$index]) && $file->isValid()) {
                    $newGallery[] = $uploadFile($file, 'gallery');
                }
            }
        }

    
        // -------------------- UPDATE SLUG --------------------
        $slug = Str::slug($request->project_name);
    
        // If someone else has same slug → append ID
        $existingSlug = BuiltToSuitGallery::where('slug', $slug)->where('id', '!=', $built->id)->exists();
        if ($existingSlug) {
            $slug .= '-' . $built->id;
        }
    
        // -------------------- SAVE UPDATED DATA --------------------
        $built->banner_heading      = $request->banner_heading;
        $built->banner_image        = $bannerImagePath;
        $built->project_name = $request->project_name;
        $built->slug = $slug;
        $built->thumbnail_image = $thumbnailPath;
        $built->gallery_images = json_encode(array_values($newGallery));
        $built->modified_by          = Auth::id();
        $built->modified_at          = Carbon::now();
        $built->save();
    
        return redirect()->route('manage-gallery-built.index')
                         ->with('message', 'Project updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = BuiltToSuitGallery::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-gallery-built.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }



}