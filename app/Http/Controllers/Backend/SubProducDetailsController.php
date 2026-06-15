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
use App\Models\ProductDetail;
use App\Models\SubProduct;

class SubProducDetailsController extends Controller
{

    public function index()
    {
        $products = ProductDetail::whereNull('deleted_by')
            ->with('subProduct') // ✅ eager load relation
            ->get();
        // dd($products);

        return view('backend.product.products_details.index', compact('products'));
    }

    public function create(Request $request)
    {
        $sub_product = SubProduct::whereNull('deleted_by')->get();

        return view('backend.product.products_details.create', compact('sub_product'));
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validation with custom messages
        $validatedData = $request->validate([
            'sec_title' => 'required|string',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_product_id' => 'required|exists:sub_products,id',
            'sub_product_description' => 'required|string',
            'thumbnail_image' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',

            // arrays
            'gallery_image.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'specifications.*'  => 'required|string',
            'value.*'           => 'required|string',
            'table_heading.*'   => 'required|string',
            'desc.*'            => 'required|string',
        ], [
            'sub_product_id.required' => 'Please select a Sub Product.',
            'sub_product_id.exists'   => 'The selected Sub Product is invalid.',

            'sub_product_description.required' => 'Please enter a Sub Product Description.',

            'sec_title.required' => 'Please enter a Sub Product Description.',

            'banner_image.image' => 'The Banner Image must be an image file.',
            'banner_image.mimes' => 'Banner Image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image.max'   => 'Banner Image size must not exceed 2MB.',

            'thumbnail_image.required' => 'Please upload a Product Image.',
            'thumbnail_image.image'    => 'The Product Image must be an image file.',
            'thumbnail_image.mimes'    => 'Product Image must be a file of type: jpg, jpeg, png, webp.',
            'thumbnail_image.max'      => 'Product Image size must not exceed 2MB.',

            'gallery_image.*.image' => 'Each Gallery Image must be an image file.',
            'gallery_image.*.mimes' => 'Each Gallery Image must be jpg, jpeg, png, or webp.',
            'gallery_image.*.max'   => 'Each Gallery Image must not exceed 2MB.',

            'specifications.*.required' => 'Specification field cannot be empty.',
            'value.*.required'          => 'Value field cannot be empty.',

            'table_heading.*.required' => 'Feature Heading is required.',
            'desc.*.required'          => 'Feature Description is required.',
        ]);

        // ✅ Step 2: Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = null;
        }

        // ✅ Step 3: Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/products/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        }

        // ✅ Step 4: Handle multiple gallery images
        $galleryImages = [];
        if ($request->hasFile('gallery_image')) {
            foreach ($request->file('gallery_image') as $file) {
                $galleryImageName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
                $galleryPath = 'uploads/gallery/';
                $file->move(public_path($galleryPath), $galleryImageName);
                $galleryImages[] = $galleryPath . $galleryImageName;
            }
        }

        // ✅ Step 5: JSON Encode Table Data
        $specifications = [];
        if ($request->has('specifications')) {
            foreach ($request->specifications as $index => $spec) {
                $specifications[] = [
                    'specification' => $spec,
                    'value'         => $request->value[$index] ?? null,
                ];
            }
        }

        $features = [];
        if ($request->has('table_heading')) {
            foreach ($request->table_heading as $index => $heading) {
                $features[] = [
                    'heading'     => $heading,
                    'description' => $request->desc[$index] ?? null,
                ];
            }
        }

        // ✅ Step 6: Save in DB
        $detailedPage = new ProductDetail(); 
        $detailedPage->banner_image = $validatedData['banner_image'];
        $detailedPage->sub_product_id = $request->sub_product_id;
        $detailedPage->sec_title = $request->sec_title;
        $detailedPage->sub_product_description = $request->sub_product_description;
        $detailedPage->thumbnail_image = $validatedData['thumbnail_image'];
        $detailedPage->gallery_images = json_encode($galleryImages);
        $detailedPage->specifications = json_encode($specifications);
        $detailedPage->features = json_encode($features);

        $detailedPage->created_by = Auth::id();
        $detailedPage->created_at = Carbon::now();

        $detailedPage->save();

        return redirect()->route('manage-detailed-page.index')
            ->with('message', 'Detailed Page created successfully!');
    }

    public function edit($id)
    {
        $banner_details = ProductDetail::findOrFail($id);

        $sub_product = SubProduct::whereNull('deleted_by')->get();

        return view('backend.product.products_details.edit', compact(
            'banner_details',
            'sub_product'
        ));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        // ✅ Step 1: Validation with same rules
        $validatedData = $request->validate([
            'sec_title' => 'required|string',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_product_id' => 'required|exists:sub_products,id',
            'sub_product_description' => 'required|string',
            'thumbnail_image' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:2048',

            'gallery_image.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'specifications.*'  => 'required|string',
            'value.*'           => 'required|string',
            'table_heading.*'   => 'required|string',
            'desc.*'            => 'required|string',
        ], [
            'sub_product_id.required' => 'Please select a Sub Product.',
            'sub_product_id.exists'   => 'The selected Sub Product is invalid.',

            'sub_product_description.required' => 'Please enter a Sub Product Description.',

            'sec_title.required' => 'Please enter a Section Title.',

            'banner_image.image' => 'The Banner Image must be an image file.',
            'banner_image.mimes' => 'Banner Image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image.max'   => 'Banner Image size must not exceed 2MB.',

            'thumbnail_image.image'    => 'The Product Image must be an image file.',
            'thumbnail_image.mimes'    => 'Product Image must be a file of type: jpg, jpeg, png, webp.',
            'thumbnail_image.max'      => 'Product Image size must not exceed 2MB.',

            'gallery_image.*.image' => 'Each Gallery Image must be an image file.',
            'gallery_image.*.mimes' => 'Each Gallery Image must be jpg, jpeg, png, or webp.',
            'gallery_image.*.max'   => 'Each Gallery Image must not exceed 2MB.',

            'specifications.*.required' => 'Specification field cannot be empty.',
            'value.*.required'          => 'Value field cannot be empty.',

            'table_heading.*.required' => 'Feature Heading is required.',
            'desc.*.required'          => 'Feature Description is required.',
        ]);

        // ✅ Step 2: Find record
        $detailedPage = ProductDetail::findOrFail($id);

        // ✅ Step 3: Handle Banner Image update
        if ($request->hasFile('banner_image')) {
            // delete old file if exists
            if ($detailedPage->banner_image && file_exists(public_path($detailedPage->banner_image))) {
                unlink(public_path($detailedPage->banner_image));
            }
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = $detailedPage->banner_image;
        }

        // ✅ Step 4: Handle Thumbnail Image update
        if ($request->hasFile('thumbnail_image')) {
            if ($detailedPage->thumbnail_image && file_exists(public_path($detailedPage->thumbnail_image))) {
                unlink(public_path($detailedPage->thumbnail_image));
            }
            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/products/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        } else {
            $validatedData['thumbnail_image'] = $detailedPage->thumbnail_image;
        }

        // ✅ Step 5: Handle multiple gallery images
           // ✅ Step 5: Handle Gallery Images update
        // $existingGallery = json_decode($detailedPage->gallery_images, true) ?? [];
        // $submittedGallery = $request->input('existing_gallery', []); // remaining from form

        // // Delete files that were removed
        // $deletedImages = array_diff($existingGallery, $submittedGallery);
        // foreach ($deletedImages as $delImg) {
        //     $filePath = public_path('uploads/home/' . $delImg);
        //     if (file_exists($filePath)) {
        //         unlink($filePath);
        //     }
        // }

        // // Start with submitted (remaining) gallery images
        // $finalGallery = $submittedGallery;

        // // Add new uploaded images
        // if ($request->hasFile('gallery_image')) {
        //     foreach ($request->file('gallery_image') as $gallery) {
        //         $galleryName = time() . rand(10, 999) . '.' . $gallery->getClientOriginalExtension();
        //         $gallery->move(public_path('uploads/home'), $galleryName);
        //         $finalGallery[] = $galleryName;
        //     }
        // }

        // // Save final gallery list
        // $detailedPage->gallery_images = json_encode($finalGallery);
        
        
        // Handle gallery updates
        $existingGallery = json_decode($detailedPage->gallery_images, true) ?? [];
        $submittedGallery = $request->input('existing_gallery', []);
        
        // Delete removed files
        $deletedImages = array_diff($existingGallery, $submittedGallery);
        foreach ($deletedImages as $delImg) {
            $filePath = public_path($delImg);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Keep remaining
        $finalGallery = $submittedGallery;
        
        // Add new uploads
        if ($request->hasFile('gallery_image')) {
            foreach ($request->file('gallery_image') as $gallery) {
                $galleryName = time() . rand(10, 999) . '.' . $gallery->getClientOriginalExtension();
                $gallery->move(public_path('uploads/home'), $galleryName);
                $finalGallery[] = 'uploads/home/' . $galleryName; // ✅ now includes path
            }
        }
        
        // Save
        $detailedPage->gallery_images = json_encode($finalGallery);



        // ✅ Step 6: JSON Encode Table Data
        $specifications = [];
        if ($request->has('specifications')) {
            foreach ($request->specifications as $index => $spec) {
                $specifications[] = [
                    'specification' => $spec,
                    'value'         => $request->value[$index] ?? null,
                ];
            }
        }

        $features = [];
        if ($request->has('table_heading')) {
            foreach ($request->table_heading as $index => $heading) {
                $features[] = [
                    'heading'     => $heading,
                    'description' => $request->desc[$index] ?? null,
                ];
            }
        }

        // ✅ Step 7: Update DB
        $detailedPage->banner_image = $validatedData['banner_image'];
        $detailedPage->sub_product_id = $request->sub_product_id;
        $detailedPage->sec_title = $request->sec_title;
        $detailedPage->sub_product_description = $request->sub_product_description;
        $detailedPage->thumbnail_image = $validatedData['thumbnail_image'];
        // $detailedPage->gallery_images = json_encode($galleryImages);
        $detailedPage->specifications = json_encode($specifications);
        $detailedPage->features = json_encode($features);

        $detailedPage->modified_by = Auth::id();
        $detailedPage->modified_at = Carbon::now();

        $detailedPage->save();

        return redirect()->route('manage-detailed-page.index')
            ->with('message', 'Detailed Page updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ProductDetail::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-detailed-page.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}