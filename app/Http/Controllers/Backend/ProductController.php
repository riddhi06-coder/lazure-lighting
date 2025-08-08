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


class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['category.application'])
            ->whereNull('deleted_by')
            ->orderBy('application_id') 
            ->orderBy('category_id')
            ->get()
            ->groupBy(fn($product) => $product->category->application->application_type ?? 'No Application Type');

        return view('backend.product.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $applications = Applications::whereNull('deleted_by')->get();
        $categories = Category::whereNull('deleted_by')->get(); 

        return view('backend.product.products.create', compact('applications', 'categories'));
    }

    public function getCategoriesByApplication($applicationId)
    {
        $categories = Category::where('application_id', $applicationId)
            ->whereNull('deleted_by')
            ->get();

        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $rules = [
            'application_type' => 'required|exists:application_type,id',
            'parent_category'  => 'required|exists:category,id',
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product'          => 'required|string|max:255',
            'thumbnail_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'application_type.required' => 'The Application Type is required.',
            'application_type.exists'   => 'The selected Application Type is invalid.',

            'parent_category.required'  => 'The Category field is required.',
            'parent_category.exists'    => 'The selected Category is invalid.',

            'banner_image.image'        => 'The uploaded banner must be an image.',
            'banner_image.mimes'        => 'Allowed banner formats: jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The banner image must be less than 2MB.',

            'thumbnail_image.required'  => 'The Thumbnail Image is required.',
            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',

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

        $slug = Str::slug($validatedData['product']);

        Product::create([
            'banner_title'     => $validatedData['banner_title'],
            'banner_image'     => $validatedData['banner_image'],
            'application_id'   => $validatedData['application_type'],
            'category_id'      => $validatedData['parent_category'],
            'product'          => $validatedData['product'],
            'thumbnail_image'  => $validatedData['thumbnail_image'],
            'slug'             => $slug,
            'created_by'       => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);

        return redirect()->route('manage-product.index')->with('message', 'Product added successfully!');
    }

    public function edit($id)
    {
        $applications = Applications::whereNull('deleted_by')->get();
        $banner_details = Product::findOrFail($id);

        // Get categories only for the selected application type
        $categories = Category::where('application_id', $banner_details->application_id)
                            ->whereNull('deleted_by')
                            ->get();

        return view('backend.product.products.edit', compact('banner_details','applications', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'application_type' => 'required|exists:application_type,id',
            'parent_category'  => 'required|exists:category,id',
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product'          => 'required|string|max:255',
            'thumbnail_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'application_type.required' => 'The Application Type is required.',
            'application_type.exists'   => 'The selected Application Type is invalid.',

            'parent_category.required'  => 'The Category field is required.',
            'parent_category.exists'    => 'The selected Category is invalid.',

            'banner_image.image'        => 'The uploaded banner must be an image.',
            'banner_image.mimes'        => 'Allowed banner formats: jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The banner image must be less than 2MB.',

            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',

            'product.required'          => 'The Product name is required.',
            'product.max'               => 'The Product name may not be greater than 255 characters.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // Find the product
        $product = Product::findOrFail($id);

        // ✅ Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($product->banner_image && file_exists(public_path($product->banner_image))) {
                unlink(public_path($product->banner_image));
            }

            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = $product->banner_image; // Keep old image
        }

        // ✅ Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            // Delete old image if exists
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

        // Generate slug
        $slug = Str::slug($validatedData['product']);

        // ✅ Update product
        $product->update([
            'banner_title'     => $validatedData['banner_title'],
            'banner_image'     => $validatedData['banner_image'],
            'application_id'   => $validatedData['application_type'],
            'category_id'      => $validatedData['parent_category'],
            'product'          => $validatedData['product'],
            'thumbnail_image'  => $validatedData['thumbnail_image'],
            'slug'             => $slug,
            'modified_by'       => Auth::id(),
            'modified_at'       => Carbon::now(),
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