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
use App\Models\IndividualCatalog;


class IndividualSeriesController extends Controller
{

    public function index()
    {
        $catalogs = IndividualCatalog::wherenull('deleted_by')->orderBy('id', 'asc')->get();
        return view('backend.catalog.individual.index', compact('catalogs'));
    }

    public function create(Request $request)
    {
        $hasFirstRecord = IndividualCatalog::wherenull('deleted_by')->exists(); 
        return view('backend.catalog.individual.create', compact('hasFirstRecord'));
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
        if (!$file) return null;   // <----- IMPORTANT FIX

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

    // Upload Banner Image (nullable)
    $bannerImagePath = $uploadFile($request->file('banner_image'), "banner");

    // Upload Thumbnail Image (required)
    $thumbnailImagePath = $uploadFile($request->file('thumbnail_image'), "thumbnail");

    // Upload Document File (required)
    $documentPath = $uploadFile($request->file('document_file'), "documents");

    // =======================
    //  SAVE TO DATABASE
    // =======================
    $catalog = new IndividualCatalog();
    $catalog->banner_heading   = $request->banner_heading;
    $catalog->banner_image     = $bannerImagePath;
    $catalog->section_title    = $request->section_title;
    $catalog->thumbnail_image  = $thumbnailImagePath;
    $catalog->document_file    = $documentPath;
    $catalog->created_by       = Auth::id();
    $catalog->created_at       = Carbon::now();
    $catalog->save();

    return redirect()->route('manage-individual-series-catalog.index')
        ->with('message', 'Full catalog added successfully!');
}

    public function edit($id)
    {
        $catalog = IndividualCatalog::findOrFail($id);
        $isFirstRecord = IndividualCatalog::orderBy('id', 'asc')->first()->id == $id;
    
        return view('backend.catalog.individual.edit', compact('catalog', 'isFirstRecord'));
    }

    public function update(Request $request, $id)
    {
        $catalog = IndividualCatalog::findOrFail($id);
    
        $request->validate([
            'banner_heading'   => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    
            'section_title'    => 'nullable|string|max:255',
            'thumbnail_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    
            'document_file'    => 'nullable|mimes:pdf,doc,docx,zip|max:3072',
        ]);
    
        // Safe upload function
        $uploadFile = function ($file, $folder) {
            if (!$file) return null;
    
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $path = "uploads/built_to_suit/{$folder}/";
    
            if (!file_exists(public_path($path))) {
                mkdir(public_path($path), 0777, true);
            }
    
            $file->move(public_path($path), $fileName);
            return $path . $fileName;
        };
    
        // Text fields
        $catalog->banner_heading = $request->banner_heading;
        $catalog->section_title  = $request->section_title;
    
        // Banner Image
        if ($request->file('banner_image')) {
            @unlink(public_path($catalog->banner_image));
            $catalog->banner_image = $uploadFile($request->file('banner_image'), "banner");
        }
    
        // Thumbnail Image
        if ($request->file('thumbnail_image')) {
            @unlink(public_path($catalog->thumbnail_image));
            $catalog->thumbnail_image = $uploadFile($request->file('thumbnail_image'), "thumbnail");
        }
    
        // Document File
        if ($request->file('document_file')) {
            @unlink(public_path($catalog->document_file));
            $catalog->document_file = $uploadFile($request->file('document_file'), "documents");
        }
    
        $catalog->modified_by = Auth::id();
        $catalog->modified_at = now();
        $catalog->save();
    
        return redirect()->route('manage-individual-series-catalog.index')
            ->with('message', 'Catalog updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = IndividualCatalog::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-individual-series-catalog.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}