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
use App\Models\Brochure;


class BrochureController extends Controller
{

    public function index()
    {
        $brochures = Brochure::wherenull('deleted_by')->get();
        return view('backend.catalog.brochure.index', compact('brochures'));
    }

    public function create(Request $request)
    {
        $isFirst = Brochure::wherenull('deleted_by')->count() == 0;
        return view('backend.catalog.brochure.create', compact('isFirst'));
    }
    
    public function store(Request $request)
    {
        // =======================
        //  VALIDATION
        // =======================
        $request->validate([
            'banner_heading'   => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title'    => 'nullable|string|max:255',
            'thumbnail_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'document_file'    => 'required|mimes:pdf,doc,docx,zip|max:3072',
        ]);
    
        // =======================
        //  FILE UPLOAD HELPER
        // =======================
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $path = "uploads/built_to_suit/{$folder}/";
    
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }
    
            $file->move(public_path($path), $fileName);
            return $path . $fileName;
        };
    
        // =======================
        //  UPLOAD FILES
        // =======================
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $uploadFile($request->file('banner_image'), "banner");
        }
    
        $thumbnailImagePath = $uploadFile($request->file('thumbnail_image'), "thumbnail");
        $documentPath       = $uploadFile($request->file('document_file'), "documents");
    
        // =======================
        //  SAVE TO DATABASE
        // =======================
        $catalog = new Brochure();
        $catalog->banner_heading   = $request->banner_heading;
        $catalog->banner_image     = $bannerImagePath;
        $catalog->section_title    = $request->section_title;
        $catalog->thumbnail_image  = $thumbnailImagePath;
        $catalog->document_file    = $documentPath;
        $catalog->created_by       = Auth::id();
        $catalog->created_at       = now();
        $catalog->save();
    
        return redirect()->route('manage-brochure.index')
            ->with('message', 'Brochure added successfully!');
    }
    
    public function edit($id)
    {
        $catalog = Brochure::findOrFail($id);
        return view('backend.catalog.brochure.edit', compact('catalog'));
    }
    
    public function update(Request $request, $id)
    {
        $catalog = Brochure::findOrFail($id);
    
        // =======================
        //  VALIDATION
        // =======================
        $request->validate([
            'banner_heading'   => 'nullable|string|max:255',
    
            // Only required if user uploads a new file
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'thumbnail_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    
            'section_title'    => 'nullable|string|max:255',
    
            // Document optional during update
            'document_file'    => 'nullable|mimes:pdf,doc,docx,zip|max:3072',
        ]);
    
        // =======================
        //  FILE UPLOAD HELPER
        // =======================
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $path = "uploads/built_to_suit/{$folder}/";
    
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }
    
            $file->move(public_path($path), $fileName);
            return $path . $fileName;
        };
    
        // =======================
        //  UPDATE FIELDS
        // =======================
        $catalog->banner_heading = $request->banner_heading;
        $catalog->section_title  = $request->section_title;
    
        // =======================
        //  UPDATE BANNER IMAGE
        // =======================
        if ($request->hasFile('banner_image')) {
    
            // Delete old file
            if (!empty($catalog->banner_image) && file_exists(public_path($catalog->banner_image))) {
                unlink(public_path($catalog->banner_image));
            }
    
            // Upload new
            $catalog->banner_image = $uploadFile($request->file('banner_image'), "banner");
        }
    
        // =======================
        //  UPDATE THUMBNAIL IMAGE
        // =======================
        if ($request->hasFile('thumbnail_image')) {
    
            // Delete old file
            if (!empty($catalog->thumbnail_image) && file_exists(public_path($catalog->thumbnail_image))) {
                unlink(public_path($catalog->thumbnail_image));
            }
    
            // Upload new
            $catalog->thumbnail_image = $uploadFile($request->file('thumbnail_image'), "thumbnail");
        }
    
        // =======================
        //  UPDATE DOCUMENT FILE
        // =======================
        if ($request->hasFile('document_file')) {
    
            // Delete old file
            if (!empty($catalog->document_file) && file_exists(public_path($catalog->document_file))) {
                unlink(public_path($catalog->document_file));
            }
    
            // Upload new
            $catalog->document_file = $uploadFile($request->file('document_file'), "documents");
        }
    
        // =======================
        //  SAVE
        // =======================
        $catalog->modified_by = Auth::id();
        $catalog->modified_at = Carbon::now();
        $catalog->save();
    
        return redirect()->route('manage-brochure.index')
                         ->with('message', 'Brochure updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Brochure::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-brochure.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}