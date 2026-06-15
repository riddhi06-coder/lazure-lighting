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
use App\Models\BuiltToSuit;


class BuiltToSuitController extends Controller
{

    public function index()
    {
        $builtToSuit = BuiltToSuit::wherenull('deleted_by')->get(); 
        return view('backend.built_to_suit.index', compact('builtToSuit'));
    }

    public function create(Request $request)
    {
        return view('backend.built_to_suit.create');
    }

    public function store(Request $request)
    {
        // âœ… Validate
        $validatedData = $request->validate([
            'banner_heading'       => 'required|string|max:255',
            'banner_image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_icon'         => 'required|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'detail_heading'       => 'required|array|min:1',
            'detail_heading.*'     => 'required|string|max:255',
            'detail_description'   => 'required|array|min:1',
            'detail_description.*' => 'required|string',

            'section_title'        => 'required|string|max:255',
            'section_description'  => 'required|string',

            'print_title'          => 'required|array|min:1',
            'print_title.*'        => 'required|string|max:255',
            'print_icon'           => 'required|array|min:1',
            'print_icon.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'print_description'    => 'required|array|min:1',
            'print_description.*'  => 'required|string',
            
            'gallery_images'      => 'required|array|min:1',
            'gallery_images.*'    => 'image|mimes:jpg,jpeg,png,webp,svg|max:2048',

        ], [
            // ðŸ”” Custom Messages
            'banner_heading.required'      => 'Banner heading is required.',
            'banner_image.required'        => 'Please upload a banner image.',
            'banner_image.mimes'           => 'Banner image must be jpg, jpeg, png or webp.',
            'section_image.required'       => 'Please upload a section image.',
            'section_icon.required'        => 'Please upload a section icon.',
            'detail_heading.*.required'    => 'Each feature must have a heading.',
            'detail_description.*.required'=> 'Each feature must have a description.',
            'section_title.required'       => 'Section title is required.',
            'section_description.required' => 'Section description is required.',
            'print_title.*.required'       => 'Each process must have a title.',
            'print_icon.*.mimes'           => 'Process icon must be jpg, jpeg, png, webp or svg.',
            'print_description.*.required' => 'Each process must have a description.',
            
            'gallery_images.required'   => 'Please upload at least one gallery image.',
            'gallery_images.*.mimes'    => 'Gallery image must be jpg, jpeg, png, webp or svg.',
            'gallery_images.*.max'      => 'Each gallery image must be less than 2MB.',

        ]);


        // âœ… File Upload Helper
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/built_to_suit/"), $fileName);
            return "uploads/built_to_suit/" . $fileName;
        };

        // âœ… Upload Banner Image
        $bannerImagePath = $request->hasFile('banner_image') 
            ? $uploadFile($request->file('banner_image'), 'banner') 
            : null;

        // âœ… Upload Section Image
        $sectionImagePath = $request->hasFile('section_image') 
            ? $uploadFile($request->file('section_image'), 'section') 
            : null;

        // âœ… Upload Section Icon
        $sectionIconPath = $request->hasFile('section_icon') 
            ? $uploadFile($request->file('section_icon'), 'icons') 
            : null;

        // âœ… Handle Features (store as JSON)
        $features = [];
        if ($request->has('detail_heading')) {
            foreach ($request->detail_heading as $index => $heading) {
                $features[] = [
                    'heading'     => $heading,
                    'description' => $request->detail_description[$index] ?? '',
                ];
            }
        }

        // âœ… Handle Process Details (store as JSON with icon upload)
        $processDetails = [];
        if ($request->has('print_title')) {
            foreach ($request->print_title as $index => $title) {
                $iconPath = null;
                if ($request->hasFile("print_icon.$index")) {
                    $iconPath = $uploadFile($request->file("print_icon.$index"), 'process_icons');
                }
                $processDetails[] = [
                    'title'       => $title,
                    'icon'        => $iconPath,
                    'description' => $request->print_description[$index] ?? '',
                ];
            }
        }


        // ✔ Handle Gallery Images (store as JSON)
        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $imgPath = $uploadFile($file, 'gallery');
                $gallery[] = $imgPath;
            }
        }

    
        // âœ… Save in DB
        $built = new BuiltToSuit();
        $built->banner_heading      = $request->banner_heading;
        $built->banner_image        = $bannerImagePath;
        $built->section_image       = $sectionImagePath;
        $built->section_icon        = $sectionIconPath;
        $built->features            = json_encode($features, JSON_UNESCAPED_UNICODE);
        $built->section_title       = $request->section_title;
        $built->section_description = $request->section_description;
        $built->process_details     = json_encode($processDetails, JSON_UNESCAPED_UNICODE);
        $built->gallery             = json_encode($gallery, JSON_UNESCAPED_UNICODE);
        
        $built->meta_title       = $request->meta_title;
        $built->meta_description = $request->meta_description;
        $built->cannonical       = $request->cannonical;
        $built->hreflang         = $request->hreflang;
        $built->og_tag           = $request->og_tag;
        $built->twitter_card_tag = $request->twitter_card_tag;
        
        $built->created_by          = Auth::id();
        $built->created_at          = Carbon::now();
        $built->save();

        return redirect()->route('manage-built-to-suit.index')->with('message', 'Built to Suit entry created successfully!');
    }

    public function edit($id)
    {
        $built_to_suit = BuiltToSuit::findOrFail($id);
        return view('backend.built_to_suit.edit', compact('built_to_suit'));
    }


    public function update(Request $request, $id)
    {
        // dd($request);
        $built = BuiltToSuit::findOrFail($id);

        // âœ… Validation
        $validatedData = $request->validate([
            'banner_heading'       => 'required|string|max:255',
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_icon'         => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'detail_heading'       => 'required|array|min:1',
            'detail_heading.*'     => 'required|string|max:255',
            'detail_description'   => 'required|array|min:1',
            'detail_description.*' => 'required|string',

            'section_title'        => 'required|string|max:255',
            'section_description'  => 'required|string',

            'print_title'          => 'required|array|min:1',
            'print_title.*'        => 'required|string|max:255',
            'print_icon'           => 'nullable|array',
            'print_icon.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'print_description'    => 'required|array|min:1',
            'print_description.*'  => 'required|string',
            
            'gallery_images.*'     => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        // âœ… File Upload Helper
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("uploads/built_to_suit/"), $fileName);
            return "uploads/built_to_suit/" . $fileName;
        };

        // âœ… Upload / Keep old files
        $bannerImagePath = $request->hasFile('banner_image')
            ? $uploadFile($request->file('banner_image'), 'banner')
            : $built->banner_image;

        $sectionImagePath = $request->hasFile('section_image')
            ? $uploadFile($request->file('section_image'), 'section')
            : $built->section_image;

        $sectionIconPath = $request->hasFile('section_icon')
            ? $uploadFile($request->file('section_icon'), 'icons')
            : $built->section_icon;

        // âœ… Handle Features (store as JSON)
        $features = [];
        if ($request->has('detail_heading')) {
            foreach ($request->detail_heading as $index => $heading) {
                $features[] = [
                    'heading'     => $heading,
                    'description' => $request->detail_description[$index] ?? '',
                ];
            }
        }

        // âœ… Handle Process Details (store as JSON with icon upload)
        $processDetails = [];
        if ($request->has('print_title')) {
            foreach ($request->print_title as $index => $title) {
                $iconPath = null;

                if ($request->hasFile("print_icon.$index")) {
                    $iconPath = $uploadFile($request->file("print_icon.$index"), 'process_icons');
                } else {
                    // If no new upload, keep old one
                    $oldProcess = json_decode($built->process_details, true);
                    $iconPath = $oldProcess[$index]['icon'] ?? null;
                }

                $processDetails[] = [
                    'title'       => $title,
                    'icon'        => $iconPath,
                    'description' => $request->print_description[$index] ?? '',
                ];
            }
        }
        
        
        // =========================
        // GALLERY UPDATE - KEEP OLD + APPEND NEW
        // =========================
        
        // Existing stored gallery images
       // Existing stored gallery images


        // 1️⃣ Get "still existing" images from the form
        $newGallery = $request->existing_gallery ?? [];

        // 2️⃣ Remove these images from OLD array → files to delete
        $oldGallery = json_decode($built->gallery, true) ?? [];
        $imagesToDelete = array_diff($oldGallery, $newGallery);
        
        foreach ($imagesToDelete as $deleteImg) {
            if (file_exists(public_path($deleteImg))) {
                unlink(public_path($deleteImg));
            }
        }
        
        // 3️⃣ Add newly uploaded images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $imageFile) {
                if ($imageFile->isValid()) {
                    $path = $uploadFile($imageFile, 'gallery');
                    $newGallery[] = $path;
                }
            }
        }





        // âœ… Update record
        $built->banner_heading      = $request->banner_heading;
        $built->banner_image        = $bannerImagePath;
        $built->section_image       = $sectionImagePath;
        $built->section_icon        = $sectionIconPath;
        $built->features            = json_encode($features, JSON_UNESCAPED_UNICODE);
        $built->section_title       = $request->section_title;
        $built->section_description = $request->section_description;
        $built->process_details     = json_encode($processDetails, JSON_UNESCAPED_UNICODE);
        $built->gallery = json_encode(array_values($newGallery));
        
        $built->meta_title       = $request->meta_title;
        $built->meta_description = $request->meta_description;
        
        
        $built->cannonical       = $request->cannonical;
        $built->hreflang         = $request->hreflang;
        $built->og_tag           = $request->og_tag;
        $built->twitter_card_tag = $request->twitter_card_tag;
        
        
        $built->modified_by          = Auth::id();
        $built->modified_at          = Carbon::now();
        $built->save();

        return redirect()->route('manage-built-to-suit.index')->with('message', 'Built to Suit entry updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = BuiltToSuit::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-built-to-suit.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}