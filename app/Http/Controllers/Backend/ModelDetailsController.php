<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Models\SubProduct;
use App\Models\ModelDetail;


class ModelDetailsController extends Controller
{

//     public function index()
// {
//     // Fetch all model details with sub-products
//     $modelDetails = ModelDetail::with('subProduct')->get()->wherenull('deleted_by')->groupBy('sub_product_id');
//     // dd($modelDetails);

//     // Lookup arrays for categories and applications
//     $categories = \DB::table('category')->pluck('category', 'id')->toArray();
//     $applications = \DB::table('application_type')->pluck('application_type', 'id')->toArray();

//     // Add category_names and application_names arrays to each sub-product
//     $modelDetails->transform(function($details) use ($categories, $applications) {
//         $subProduct = $details->first()->subProduct;

//         if ($subProduct) {
//             // Convert comma-separated category IDs to array of names
//             $catIds = explode(',', $subProduct->category_id);
//             $subProduct->category_names = collect($catIds)
//                 ->map(fn($id) => $categories[$id] ?? null)
//                 ->filter()
//                 ->toArray();

//             // Convert comma-separated application IDs to array of names
//             $appIds = explode(',', $subProduct->application_id);
//             $subProduct->application_names = collect($appIds)
//                 ->map(fn($id) => $applications[$id] ?? null)
//                 ->filter()
//                 ->toArray();
//         }

//         return $details;
//     });

//     return view('backend.product.model_details.index', compact('modelDetails'));
// }


public function index()
{
    // Fetch all model details with sub-products
    $modelDetails = ModelDetail::with('subProduct')
        ->get()
        ->whereNull('deleted_by')
        ->groupBy('sub_product_id');

    // Lookup arrays for categories and applications
    $categories = \DB::table('category')->pluck('category', 'id')->toArray();
    $applications = \DB::table('application_type')->pluck('application_type', 'id')->toArray();

    // Add category_names and application_names arrays to each sub-product
    $modelDetails->transform(function ($details) use ($categories, $applications) {
        $subProduct = $details->first()->subProduct;

        if ($subProduct) {
            // Convert comma-separated category IDs to array of names
            $catIds = explode(',', $subProduct->category_id);
            $subProduct->category_names = collect($catIds)
                ->map(function ($id) use ($categories) {
                    return $categories[$id] ?? null;
                })
                ->filter()
                ->toArray();

            // Convert comma-separated application IDs to array of names
            $appIds = explode(',', $subProduct->application_id);
            $subProduct->application_names = collect($appIds)
                ->map(function ($id) use ($applications) {
                    return $applications[$id] ?? null;
                })
                ->filter()
                ->toArray();
        }

        return $details;
    });

    return view('backend.product.model_details.index', compact('modelDetails'));
}




    public function create(Request $request)
    {
        $SubProduct = SubProduct::whereNull('deleted_by')->get();  

        return view('backend.product.model_details.create', compact('SubProduct'));
    }

    public function store(Request $request)
    {
        Log::info('➡️ ModelDetail::store() called', ['request' => $request->all()]);

        $request->validate([
            'product_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_product_id'     => 'required|exists:sub_products,id',
            'model_details_file' => 'nullable|mimes:csv,xls,xlsx|max:2048',
        ]);

        // ✅ Product image upload
        $productImagePath = null;
        if ($request->hasFile('product_image')) {
            $productImage = $request->file('product_image');
            $imageName = time() . rand(10, 999) . '.' . $productImage->getClientOriginalExtension();
            $productImage->move(public_path('uploads/models'), $imageName);
            $productImagePath = 'uploads/models/' . $imageName;
        }

        // ✅ Import Excel Data (if file exists)
        if ($request->hasFile('model_details_file')) {
            $data = Excel::toArray([], $request->file('model_details_file'));

            foreach ($data[0] as $index => $row) {
                if ($index == 0) continue; // skip header

                ModelDetail::create([
                    'sub_product_id'    => $request->sub_product_id,
                    'product_image'     => $productImagePath,
                    'model_name'        => $row[0] ?? null,
                    'model_no'          => $row[1] ?? null,
                    'size'              => $row[2] ?? null,
                    'wattage'           => $row[3] ?? null,
                    'lumens'            => $row[4] ?? null,
                    'cct'               => $row[5] ?? null,
                    'cri'               => $row[6] ?? null,
                    'beam_angle'        => $row[7] ?? null,
                    'accessories'       => $row[8] ?? null,
                    'dimming_options'   => $row[9] ?? null,

                    // 🔹 Store file paths (prepend uploads/models/files/)
                    'specssheet'             => !empty($row[10]) ? 'uploads/models/spec_sheets/' . $row[10] : null,
                    'installation_manual'   => !empty($row[11]) ? 'uploads/models/manuals/' . $row[11] : null,
                    'drawings_2d'               => !empty($row[12]) ? 'uploads/models/2d/' . $row[12] : null,
                    'drawings_3d'               => !empty($row[13]) ? 'uploads/models/3d/' . $row[13] : null,

                    'light_application' => $row[14] ?? null,
                    'mounting_type'     => $row[15] ?? null,
                    'ip_rating'         => $row[16] ?? null,
                    'orientation'       => $row[17] ?? null,
                    'optics'            => $row[18] ?? null,
                    'created_by'        => Auth::id(),
                    'created_at'        => now(),
                ]);
            }
        }

        return redirect()->route('manage-model-details.index')
            ->with('message', 'Excel imported successfully!');
    }

    public function edit($id)
    {
        $appIntro = ModelDetail::findOrFail($id);
        $SubProduct = SubProduct::whereNull('deleted_by')->get();  
        return view('backend.product.model_details.edit', compact('appIntro','SubProduct'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        Log::info('✏️ ModelDetail::update() called', [
            'id' => $id,
            'request_data' => $request->all()
        ]);
    
        $request->validate([
            'product_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_product_id'     => 'required|exists:sub_products,id',
            'model_details_file' => 'nullable|mimes:csv,xls,xlsx|max:2048',
        ]);
    
        // ✅ Fetch the record and identify its sub_product_id group
        $modelDetail = ModelDetail::findOrFail($id);
        $targetSubProductId = $modelDetail->sub_product_id;
        Log::info('📄 Found ModelDetail', [
            'model_id' => $modelDetail->id,
            'sub_product_id' => $targetSubProductId
        ]);
    
        // ✅ Handle product image update
        $productImagePath = $modelDetail->product_image;
        if ($request->hasFile('product_image')) {
            Log::info('🖼️ New product image uploaded');
    
            // Delete old image
            if ($modelDetail->product_image && file_exists(public_path($modelDetail->product_image))) {
                unlink(public_path($modelDetail->product_image));
                Log::info('🧹 Old image deleted', ['path' => $modelDetail->product_image]);
            }
    
            $productImage = $request->file('product_image');
            $imageName = time() . rand(10, 999) . '.' . $productImage->getClientOriginalExtension();
            $productImage->move(public_path('uploads/models'), $imageName);
            $productImagePath = 'uploads/models/' . $imageName;
    
            Log::info('✅ New image stored', ['path' => $productImagePath]);
        } else {
            Log::info('ℹ️ No new image uploaded — keeping existing image.');
        }
        
        
        ModelDetail::where('sub_product_id', $request->sub_product_id)->update([
            'product_image' => $productImagePath,
            'modified_by'   => Auth::id(),
            'modified_at'   => now(),
        ]);
        
        Log::info('🖼️ Product image updated for all models', [
            'sub_product_id' => $request->sub_product_id,
            'image' => $productImagePath
        ]);
            
        // ✅ If Excel file uploaded → update all records under that sub_product_id
        // if ($request->hasFile('model_details_file')) {
        //     Log::info('📂 Excel file uploaded for update');
    
        //     $data = Excel::toArray([], $request->file('model_details_file'));
        //     $rowCount = count($data[0]);
        //     Log::info('📊 Excel parsed successfully', ['rows' => $rowCount]);
    
        //     foreach ($data[0] as $index => $row) {
        //         if ($index == 0) continue; // skip header
    
        //         $modelNo = $row[1] ?? null;
        //         $existing = ModelDetail::where('sub_product_id', $targetSubProductId)
        //             // ->where('model_no', $modelNo)
        //             ->first();
    
        //         Log::info('🔍 Checking model', [
        //             'row_index' => $index,
        //             'model_no' => $modelNo,
        //             'exists' => $existing ? true : false
        //         ]);
    
        //         $modelData = [
        //             'sub_product_id'      => $targetSubProductId,
        //             'product_image'       => $productImagePath,
        //             'model_name'          => $row[0] ?? null,
        //             'model_no'            => $row[1] ?? null,
        //             'size'                => $row[2] ?? null,
        //             'wattage'             => $row[3] ?? null,
        //             'lumens'              => $row[4] ?? null,
        //             'cct'                 => $row[5] ?? null,
        //             'cri'                 => $row[6] ?? null,
        //             'beam_angle'          => $row[7] ?? null,
        //             'accessories'         => $row[8] ?? null,
        //             'dimming_options'     => $row[9] ?? null,
        //             'specssheet'          => !empty($row[10]) ? 'uploads/models/spec_sheets/' . $row[10] : null,
        //             'installation_manual' => !empty($row[11]) ? 'uploads/models/manuals/' . $row[11] : null,
        //             'drawings_2d'         => !empty($row[12]) ? 'uploads/models/2d/' . $row[12] : null,
        //             'drawings_3d'         => !empty($row[13]) ? 'uploads/models/3d/' . $row[13] : null,
        //             'light_application'   => $row[14] ?? null,
        //             'mounting_type'       => $row[15] ?? null,
        //             'ip_rating'           => $row[16] ?? null,
        //             'orientation'         => $row[17] ?? null,
        //             'optics'              => $row[18] ?? null,
        //             'updated_by'          => Auth::id(),
        //             'updated_at'          => now(),
        //         ];
    
        //         if ($existing) {
        //             $existing->update($modelData);
        //             Log::info('🟢 Updated existing model', ['model_no' => $modelNo]);
        //         } else {
        //             $modelData['created_by'] = Auth::id();
        //             $modelData['created_at'] = now();
        //             ModelDetail::create($modelData);
        //             Log::info('🆕 Created new model', ['model_no' => $modelNo]);
        //         }
        //     }
    
        //     Log::info('✅ Excel import/update completed successfully');
    
        // }
        
        
        if ($request->hasFile('model_details_file')) {
            Log::info('📂 Excel file uploaded for update');
        
            // Parse Excel data
            $data = Excel::toArray([], $request->file('model_details_file'));
            $rows = $data[0] ?? [];
        
            Log::info('📊 Parsed Excel rows', ['count' => count($rows)]);
        
            if (count($rows) <= 1) {
                Log::warning('⚠️ Excel file has no data rows');
            } else {
                // Step 1️⃣ Delete existing entries for that sub_product_id
                ModelDetail::where('sub_product_id', $targetSubProductId)->delete();
                Log::info('🧹 Deleted existing records', ['sub_product_id' => $targetSubProductId]);
        
                // Step 2️⃣ Loop through Excel rows and insert new ones
                foreach ($rows as $index => $row) {
                    if ($index == 0) continue; // skip header row
        
                    // Skip empty rows
                    if (empty(array_filter($row))) continue;
        
                    $modelData = [
                        'sub_product_id'      => $targetSubProductId,
                        'product_image'       => $productImagePath,
                        'model_name'          => $row[0] ?? null,
                        'model_no'            => $row[1] ?? null,
                        'size'                => $row[2] ?? null,
                        'wattage'             => $row[3] ?? null,
                        'lumens'              => $row[4] ?? null,
                        'cct'                 => $row[5] ?? null,
                        'cri'                 => $row[6] ?? null,
                        'beam_angle'          => $row[7] ?? null,
                        'accessories'         => $row[8] ?? null,
                        'dimming_options'     => $row[9] ?? null,
                        'specssheet'          => !empty($row[10]) ? 'uploads/models/spec_sheets/' . $row[10] : null,
                        'installation_manual' => !empty($row[11]) ? 'uploads/models/manuals/' . $row[11] : null,
                        'drawings_2d'         => !empty($row[12]) ? 'uploads/models/2d/' . $row[12] : null,
                        'drawings_3d'         => !empty($row[13]) ? 'uploads/models/3d/' . $row[13] : null,
                        'light_application'   => $row[14] ?? null,
                        'mounting_type'       => $row[15] ?? null,
                        'ip_rating'           => $row[16] ?? null,
                        'orientation'         => $row[17] ?? null,
                        'optics'              => $row[18] ?? null,
                        'created_by'          => Auth::id(),
                        'created_at'          => now(),
                    ];
        
                    ModelDetail::create($modelData);
                    Log::info('🆕 Inserted new model', ['index' => $index, 'model_no' => $row[1] ?? null]);
                }
        
                Log::info('✅ All models replaced successfully for sub_product_id', ['id' => $targetSubProductId]);
            }
        }

    
        Log::info('🏁 ModelDetail update process finished successfully', ['redirect' => 'manage-model-details.index']);
    
        return redirect()->route('manage-model-details.index')
            ->with('message', 'All related model details updated successfully!');
    }


    public function destroy(string $id)
    {
        try {
            // Find the selected model detail
            $modelDetail = ModelDetail::findOrFail($id);
    
            // Get the related sub_product_id
            $subProductId = $modelDetail->sub_product_id;
    
            // Hard delete all records with the same sub_product_id
            ModelDetail::where('sub_product_id', $subProductId)->delete();
    
            return redirect()->route('manage-model-details.index')
                ->with('message', 'All records for this sub-product have been permanently deleted!');
        } catch (Exception $ex) {
            return redirect()->back()
                ->with('error', 'Something went wrong - ' . $ex->getMessage());
        }
    }


    // public function uploadSpecSheet(Request $request)
    // {
    //     if ($request->hasFile('spec_sheet')) {
    //         $savedFiles = [];
    //         foreach ($request->file('spec_sheet') as $file) {
    //             $name = $file->getClientOriginalName(); 
    //             $file->move(public_path('uploads/models/spec_sheets'), $name);
    //             $savedFiles[] = 'uploads/models/spec_sheets/'.$name;
    //         }
    //         return response()->json(['success' => true, 'files' => $savedFiles]);
    //     }
    //     return response()->json(['success' => false], 400);
    // }
    
    // public function uploadSpecSheet(Request $request)
    // {
    //     // dd($request);
    //     $request->validate([
    //         'sub_product_id' => 'required',
    //         'spec_sheet.*'    => 'required|mimes:pdf',
    //     ]);

    //     if ($request->hasFile('spec_sheet')) {
    //         $savedFiles = [];
    //         foreach ($request->file('spec_sheet') as $file) {
    //             $name = $file->getClientOriginalName();
    //             $file->move(public_path('uploads/models/spec_sheets'), $name);
    //             $savedFiles[] = 'uploads/models/spec_sheets/'.$name;
    //         }

    //        ModelDetail::where('sub_product_id', $request->sub_product_id)
    //                 ->update(['spec_upload' => 1]);

    //         return redirect()->route('manage-model-details.index')->with('message', 'Spec sheets uploaded successfully!');
    //     }

    //     return redirect()->route('manage-model-details.index')->with('error', 'No file uploaded!');
    // }


    public function uploadSpecSheet(Request $request)
    {
        $request->validate([
            'sub_product_id' => 'required',
            'spec_sheet.*'   => 'required',
        ]);

        $savedFiles = [];

        if ($request->hasFile('spec_sheet')) {
            foreach ($request->file('spec_sheet') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path('uploads/models/spec_sheets'), $name);
                $savedFiles[] = $name;
            }

            ModelDetail::where('sub_product_id', $request->sub_product_id)
                ->update(['spec_upload' => 1]);

            // ✅ Always return JSON for fetch/AJAX
            return response()->json([
                'success' => true,
                'message' => 'Batch uploaded successfully!',
                'files'   => $savedFiles
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded!'
        ], 400);
    }


    // public function uploadInstallationManual(Request $request)
    // {
    //     $request->validate([
    //         'sub_product_id' => 'required',
    //         'installation_manual.*' => 'required|mimes:pdf'
    //     ]);


    //     if ($request->hasFile('installation_manual')) {
    //         $savedFiles = [];
    //         foreach ($request->file('installation_manual') as $file) {
    //             $name = $file->getClientOriginalName();
    //             $file->move(public_path('uploads/models/manuals'), $name);
    //             $savedFiles[] = 'uploads/models/manuals/'.$name;
    //         }

    //         ModelDetail::where('sub_product_id', $request->sub_product_id)
    //                 ->update(['manual_upload' => 1]);

    //         // $files = $this->uploadMultiple($request->file('installation_manual'), 'uploads/models/manuals');

    //         return redirect()->route('manage-model-details.index')->with('message', 'Manuals uploaded successfully!');
    //     }

    //     return redirect()->route('manage-model-details.index')->with('error', 'No file uploaded!');
    // }


    public function uploadInstallationManual(Request $request)
    {
        $request->validate([
            'sub_product_id' => 'required',
            'installation_manual.*' => 'required'
        ]);

        $savedFiles = [];

        if ($request->hasFile('installation_manual')) {
            foreach ($request->file('installation_manual') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path('uploads/models/manuals'), $name);
                $savedFiles[] = $name;
            }

            ModelDetail::where('sub_product_id', $request->sub_product_id)
                        ->update(['manual_upload' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Batch uploaded successfully!',
                'files' => $savedFiles
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No file uploaded!'
        ], 400);
    }




    // public function uploadDrawings2D(Request $request)
    // {
    //     $request->validate([
    //         'sub_product_id' => 'required',
    //         'drawings_2d.*' => 'required|mimes:pdf|max:2048'
    //     ]);


    //      if ($request->hasFile('drawings_2d')) {
    //         $savedFiles = [];
    //         foreach ($request->file('drawings_2d') as $file) {
    //             $name = $file->getClientOriginalName();
    //             $file->move(public_path('uploads/models/2d'), $name);
    //             $savedFiles[] = 'uploads/models/2d/'.$name;
    //         }

    //         ModelDetail::where('sub_product_id', $request->sub_product_id)
    //                 ->update(['2d_upload' => 1]);

    //         // $files = $this->uploadMultiple($request->file('drawings_2d'), 'uploads/models/2d');


    //        return redirect()->route('manage-model-details.index')->with('message', '2D uploaded successfully!');
    //     }

    //     return redirect()->route('manage-model-details.index')->with('error', 'No file uploaded!');
    // }


    public function uploadDrawings2D(Request $request)
    {
        $request->validate([
            'sub_product_id' => 'required',
            'drawings_2d.*'  => 'required',
        ]);

        if ($request->hasFile('drawings_2d')) {
            $savedFiles = [];

            foreach ($request->file('drawings_2d') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path('uploads/models/2d'), $name);
                $savedFiles[] = 'uploads/models/2d/' . $name;
            }

            // Update the ModelDetail table
            ModelDetail::where('sub_product_id', $request->sub_product_id)
                ->update(['2d_upload' => 1]);

            // Return JSON response for AJAX
            return response()->json([
                'success' => true,
                'message' => '2D drawings uploaded successfully!',
                'files'   => $savedFiles
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No files uploaded!'
        ], 400);
    }


    // public function uploadDrawings3D(Request $request)
    // {
    //     $request->validate([
    //         'sub_product_id' => 'required',
    //         'drawings_3d.*' => 'required|mimes:zip|max:5120'
    //     ]);


    //      if ($request->hasFile('drawings_3d')) {
    //         $savedFiles = [];
    //         foreach ($request->file('drawings_3d') as $file) {
    //             $name = $file->getClientOriginalName();
    //             $file->move(public_path('uploads/models/3d'), $name);
    //             $savedFiles[] = 'uploads/models/3d/'.$name;
    //         }

    //         ModelDetail::where('sub_product_id', $request->sub_product_id)
    //                 ->update(['3d_upload' => 1]);

    //         // $files = $this->uploadMultiple($request->file('drawings_3d'), 'uploads/models/3d');

    //       return redirect()->route('manage-model-details.index')->with('message', '2D uploaded successfully!');
    //     }

    //     return redirect()->route('manage-model-details.index')->with('error', 'No file uploaded!');
    // }



    public function uploadDrawings3D(Request $request)
    {
        $request->validate([
            'sub_product_id' => 'required',
            'drawings_3d.*' => 'required'
        ]);

        if ($request->hasFile('drawings_3d')) {
            $savedFiles = [];

            foreach ($request->file('drawings_3d') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path('uploads/models/3d'), $name);
                $savedFiles[] = 'uploads/models/3d/' . $name;
            }

            ModelDetail::where('sub_product_id', $request->sub_product_id)
                ->update(['3d_upload' => 1]);

            return response()->json([
                'success' => true,
                'message' => '3D drawings uploaded successfully!',
                'files' => $savedFiles
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No files uploaded!'
        ], 400);
    }


    private function uploadMultiple($files, $path)
    {
        $savedFiles = [];

        if ($files) {
            foreach ($files as $file) {
                $fileName = $file->getClientOriginalName(); // keep original name
                $file->move(public_path($path), $fileName);

                $savedFiles[] = $path . '/' . $fileName;
            }
        }

        return $savedFiles;
    }




}