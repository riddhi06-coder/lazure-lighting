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
use App\Models\Product;
use App\Models\Applications;
use App\Models\Category;
use App\Models\LightApplications;


class ProductController extends Controller
{

    public function index()
    {
        $products = Product::whereNull('deleted_by')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($product) {
                // Convert CSV ids to arrays
                $product->application_ids = explode(',', $product->application_id);
                $product->category_ids = explode(',', $product->category_id);
                $product->light_application_ids = explode(',', $product->light_application_id);

                // Fetch related names
                $product->applications = \App\Models\Applications::whereIn('id', $product->application_ids)->pluck('application_type')->toArray();
                $product->categories   = \App\Models\Category::whereIn('id', $product->category_ids)->pluck('category')->toArray();
                $product->lightApplications = \App\Models\LightApplications::whereIn('id', $product->light_application_ids)->pluck('light_application_type')->toArray();

                return $product;
            });

            
        // Now group products by Application Type names (merged as comma separated string)
        $groupedProducts = $products->groupBy(function ($product) {
            return implode(', ', $product->applications) ?: 'No Application Type';
        });

        return view('backend.product.products.index', [
            'products' => $groupedProducts
        ]);
    }

    public function create(Request $request)
    {
        $applications = Applications::whereNull('deleted_by')->where('application_type', '!=', 'Built - To - Suit')->get();
        $categories = Category::whereNull('deleted_by')->get();
        $light_applications = LightApplications::whereNull('deleted_by')->get();  

        return view('backend.product.products.create', compact('applications', 'categories','light_applications'));
    }

    public function getCategoriesByApplication(Request $request)
    {
        $applicationIds = $request->input('ids', []);

        // Force into array
        if (!is_array($applicationIds)) {
            $applicationIds = explode(',', $applicationIds);
        }

        // Debug log
        // \Log::info('Application IDs received:', $applicationIds);

        $categories = Category::whereIn('application_id', $applicationIds)
            ->whereNull('deleted_by')
            ->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'application_type'     => 'required|array',
            'application_type.*'   => 'exists:application_type,id',
            'parent_category'      => 'required|exists:category,id',
            'light_application_type'   => 'required|array',
            'light_application_type.*' => 'exists:light_applications,id',
            'banner_title'         => 'nullable|string|max:255',
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product'              => 'required|string|max:255',
            'thumbnail_image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'other_thumbnail_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'application_type.required' => 'The Application Type is required.',
            'application_type.array'    => 'The Application Type must be an array.',
            'application_type.*.exists' => 'One or more selected Application Types are invalid.',

            'light_application_type.required' => 'The Light Application Type is required.',
            'light_application_type.array'    => 'The Light Application Type must be an array.',
            'light_application_type.*.exists' => 'One or more selected Light Application Types are invalid.',

            'parent_category.required'  => 'The Category field is required.',
            'parent_category.exists'    => 'The selected Category is invalid.',

            'banner_image.image'        => 'The uploaded banner must be an image.',
            'banner_image.mimes'        => 'Allowed banner formats: jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The banner image must be less than 2MB.',

            'thumbnail_image.required'  => 'The Thumbnail Image is required.',
            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',
            
            'other_thumbnail_image.required'  => 'The Thumbnail Image is required.',
            'other_thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'other_thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'other_thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',

            'product.required'          => 'The Product name is required.',
            'product.max'               => 'The Product name may not be greater than 255 characters.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // ✅ Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = null;
        }

        // ✅ Handle thumbnail image upload
        $thumbnailImage = $request->file('thumbnail_image');
        $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
        $thumbnailPath = 'uploads/products/';
        $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
        $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        
        
        $thumbnailImage1 = $request->file('other_thumbnail_image');
        $thumbnailImageName1 = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
        $thumbnailPath1 = 'uploads/products/';
        $thumbnailImage1->move(public_path($thumbnailPath1), $thumbnailImageName1);
        $validatedData['other_thumbnail_image'] = $thumbnailPath1 . $thumbnailImageName1;
        

        // ✅ Convert arrays into comma-separated strings
        $applicationIds = implode(',', $validatedData['application_type']);
        $lightApplicationIds = implode(',', $validatedData['light_application_type']);
        $categoryIds = implode(',', $validatedData['parent_category']);

        $slug = Str::slug($validatedData['product']);

        Product::create([
            'banner_title'           => $validatedData['banner_title'],
            'banner_image'           => $validatedData['banner_image'],
            'application_id'         => $applicationIds,
            'category_id'            => $categoryIds,
            'light_application_id'   => $lightApplicationIds,
            'product'                => $validatedData['product'],
            'thumbnail_image'        => $validatedData['thumbnail_image'],
            'thumbnail_image1'  => $validatedData['other_thumbnail_image'],
            'slug'                   => $slug,
            'created_by'             => Auth::id(),
            'created_at'             => Carbon::now(),
        ]);

        return redirect()->route('manage-product.index')->with('message', 'Product added successfully!');
    }

    public function edit($id)
    {
        $applications = Applications::whereNull('deleted_by')->where('application_type', '!=', 'Built - To - Suit')->get();
        $banner_details = Product::findOrFail($id);

        // ✅ Convert comma-separated IDs into arrays
        $selectedApplications = $banner_details->application_id 
            ? explode(',', $banner_details->application_id) 
            : [];

        $selectedLightApplications = $banner_details->light_application_id 
            ? explode(',', $banner_details->light_application_id) 
            : [];

        $selectedCategories = $banner_details->category_id ? explode(',', $banner_details->category_id) : [];

        // ✅ Load categories based on selected application(s)
        $categories = Category::whereIn('application_id', $selectedApplications)
                            ->whereNull('deleted_by')
                            ->get();

        $light_applications = LightApplications::whereNull('deleted_by')->get();

        return view('backend.product.products.edit', compact(
            'banner_details',
            'applications',
            'categories',
            'light_applications',
            'selectedApplications',
            'selectedCategories',
            'selectedLightApplications'
        ));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'application_type'        => 'required|array',
            'application_type.*'      => 'exists:application_type,id',
            'light_application_type'  => 'required|array',
            'light_application_type.*'=> 'exists:light_applications,id',
            'parent_category'         => 'required|exists:category,id',
            'banner_title'            => 'nullable|string|max:255',
            'banner_image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product'                 => 'required|string|max:255',
            'thumbnail_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'other_thumbnail_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'application_type.required' => 'The Application Type is required.',
            'application_type.array'    => 'The Application Type must be an array.',
            'application_type.*.exists' => 'One or more selected Application Types are invalid.',

            'light_application_type.required' => 'The Light Application Type is required.',
            'light_application_type.array'    => 'The Light Application Type must be an array.',
            'light_application_type.*.exists' => 'One or more selected Light Application Types are invalid.',

            'parent_category.required'  => 'The Category field is required.',
            'parent_category.exists'    => 'The selected Category is invalid.',

            'banner_image.image'        => 'The uploaded banner must be an image.',
            'banner_image.mimes'        => 'Allowed banner formats: jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The banner image must be less than 2MB.',

            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',
            
            
            'other_thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'other_thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'other_thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',

            'product.required'          => 'The Product name is required.',
            'product.max'               => 'The Product name may not be greater than 255 characters.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // Find the product
        $product = Product::findOrFail($id);

        // ✅ Handle banner image upload
        if ($request->hasFile('banner_image')) {
            if ($product->banner_image && file_exists(public_path($product->banner_image))) {
                unlink(public_path($product->banner_image));
            }

            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = $product->banner_image;
        }

        // ✅ Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            if ($product->thumbnail_image && file_exists(public_path($product->thumbnail_image))) {
                unlink(public_path($product->thumbnail_image));
            }

            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/products/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        } else {
            $validatedData['thumbnail_image'] = $product->thumbnail_image;
        }
        
        
        
        // ✅ Handle thumbnail image upload
        if ($request->hasFile('other_thumbnail_image')) {
            if ($product->thumbnail_image1 && file_exists(public_path($product->thumbnail_image1))) {
                unlink(public_path($product->thumbnail_image1));
            }

            $thumbnailImage1 = $request->file('other_thumbnail_image');
            $thumbnailImageName1 = time() . rand(10, 999) . '.' . $thumbnailImage1->getClientOriginalExtension();
            $thumbnailPath1 = 'uploads/products/';
            $thumbnailImage1->move(public_path($thumbnailPath1), $thumbnailImageName1);
            $validatedData['other_thumbnail_image'] = $thumbnailPath1 . $thumbnailImageName1;
        } else {
            $validatedData['other_thumbnail_image'] = $product->thumbnail_image1;
        }

        // ✅ Convert arrays into comma-separated strings
        $applicationIds = implode(',', $validatedData['application_type']);
        $lightApplicationIds = implode(',', $validatedData['light_application_type']);
        $categoryIds = implode(',', $validatedData['parent_category']);


        // Generate slug
        $slug = Str::slug($validatedData['product']);

        // ✅ Update product
        $product->update([
            'banner_title'         => $validatedData['banner_title'],
            'banner_image'         => $validatedData['banner_image'],
            'application_id'       => $applicationIds,
            'category_id'          => $categoryIds,
            'light_application_id' => $lightApplicationIds,
            'product'              => $validatedData['product'],
            'thumbnail_image'      => $validatedData['thumbnail_image'],
            'thumbnail_image1'      => $validatedData['other_thumbnail_image'],
            'slug'                 => $slug,
            'modified_by'          => Auth::id(),
            'modified_at'          => Carbon::now(),
        ]);

        return redirect()->route('manage-product.index')->with('message', 'Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Product::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-product.index')->with('message', 'Banner Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}