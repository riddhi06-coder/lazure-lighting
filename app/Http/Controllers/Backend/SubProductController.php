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
use App\Models\SubProduct;


class SubProductController extends Controller
{

     public function index()
    {
        $subProducts = \DB::table('sub_products')
            ->leftJoin('category', 'sub_products.category_id', '=', 'category.id')
            ->leftJoin('products', 'sub_products.product_id', '=', 'products.id')
            ->leftJoin('application_type', 'sub_products.application_id', '=', 'application_type.id')
            ->select(
                'sub_products.*',
                'category.category',
                'products.product as product_name',
                'application_type.application_type'
            )
            ->wherenull('sub_products.deleted_by')
            ->get();

        // Group by application_type, then category, then product_name
        $grouped = $subProducts->groupBy('application_type')->map(function($appGroup) {
            return $appGroup->groupBy('category')->map(function($catGroup) {
                return $catGroup->groupBy('product_name');
            });
        });

        return view('backend.product.sub_products.index', ['groupedSubProducts' => $grouped]);
    }

    public function create(Request $request)
    {
        $applications = Applications::whereNull('deleted_by')->get();
        $categories = Category::whereNull('deleted_by')->get(); 
        $product = Product::whereNull('deleted_by')->get(); 

        return view('backend.product.sub_products.create', compact('applications', 'categories','product'));
    }

    public function getProductDetails($productId)
    {
        $product = Product::where('id', $productId)
            ->whereNull('deleted_by')
            ->with(['application', 'category']) 
            ->first();

        if ($product) {
            return response()->json([
                'application_id' => $product->application_id,
                'application_type' => $product->application->application_type ?? '',
                'category_id' => $product->category_id,
                'category' => $product->category->category ?? ''
            ]);
        }

        return response()->json([], 404);
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'banner_title'       => 'nullable|string|max:255',
            'banner_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_id'         => 'required|exists:products,id',
            'application_type'   => 'required|exists:application_type,id',
            'parent_category'    => 'required|exists:category,id',
            'sub_product'        => 'required|string|max:255',
            'thumbnail_image'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // Custom validation messages
        $messages = [
            'banner_title.string'           => 'Banner Title must be valid text.',
            'banner_image.image'            => 'Banner Image must be an image file.',
            'banner_image.mimes'            => 'Banner Image must be jpg, jpeg, png, or webp.',
            'banner_image.max'              => 'Banner Image must be less than 2MB.',
            'product_id.required'           => 'Please select a Product.',
            'product_id.exists'             => 'Selected Product is invalid.',
            'application_type.required'     => 'Please select an Application Type.',
            'application_type.exists'       => 'Selected Application Type is invalid.',
            'parent_category.required'      => 'Please select a Category.',
            'parent_category.exists'        => 'Selected Category is invalid.',
            'sub_product.required'          => 'Please enter a Sub Product.',
            'sub_product.string'            => 'Sub Product must be valid text.',
            'thumbnail_image.required'      => 'Please upload a Thumbnail Image.',
            'thumbnail_image.image'         => 'Thumbnail Image must be an image file.',
            'thumbnail_image.mimes'         => 'Thumbnail Image must be jpg, jpeg, png, or webp.',
            'thumbnail_image.max'           => 'Thumbnail Image must be less than 2MB.',
        ];

        // Validate the request
        $validatedData = $request->validate($rules, $messages);

        // Handle banner image upload (optional)
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = null;
        }

        // Handle thumbnail image upload (required)
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/products/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        }


        // Generate slug from sub_product
        $slug = Str::slug($validatedData['sub_product']);

        // Optional: ensure slug is unique by appending a number if it already exists
        $originalSlug = $slug;
        $counter = 1;
        while (SubProduct::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Create and save the model
        $subProduct = new SubProduct();

        // Assign all validated inputs to model fields
        $subProduct->banner_title = $validatedData['banner_title'] ?? null;
        $subProduct->banner_image = $validatedData['banner_image'];
        $subProduct->product_id = $validatedData['product_id'];
        $subProduct->application_id = $validatedData['application_type'];
        $subProduct->category_id = $validatedData['parent_category'];
        $subProduct->sub_product = $validatedData['sub_product'];
        $subProduct->thumbnail_image = $validatedData['thumbnail_image'];
        $subProduct->slug = $slug; 
        $subProduct->created_by = Auth::id();
        $subProduct->created_at = Carbon::now();

        $subProduct->save();

        // Redirect back with success message
        return redirect()->route('manage-sub-product.index')->with('message', 'Sub Product created successfully!');
    }

    public function edit($id)
    {
        $applications = Applications::whereNull('deleted_by')->get();
        $banner_details = SubProduct::findOrFail($id);

        $categories = Category::where('application_id', $banner_details->application_id)
                            ->whereNull('deleted_by')
                            ->get();

        $product = Product::whereNull('deleted_by')->get(); 

        // dd($categories);

        return view('backend.product.sub_products.edit', compact('banner_details', 'applications', 'categories', 'product'));
    }

    public function update(Request $request, $id)
    {
        $subProduct = SubProduct::findOrFail($id);

        $rules = [
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_id'       => 'required|exists:products,id',
            'application_type' => 'required|exists:application_type,id',
            'parent_category'  => 'required|exists:category,id',
            'sub_product'      => 'required|string|max:255',
            'thumbnail_image'  => $subProduct->thumbnail_image 
                                    ? 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048' 
                                    : 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $validated = $request->validate($rules);

        // Handle banner image
        if ($request->hasFile('banner_image')) {
            if ($subProduct->banner_image && file_exists(public_path($subProduct->banner_image))) {
                unlink(public_path($subProduct->banner_image));
            }
            $file = $request->file('banner_image');
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/'), $fileName);
            $validated['banner_image'] = 'uploads/products/' . $fileName;
        } else {
            $validated['banner_image'] = $subProduct->banner_image;
        }

        // Handle thumbnail image
        if ($request->hasFile('thumbnail_image')) {
            if ($subProduct->thumbnail_image && file_exists(public_path($subProduct->thumbnail_image))) {
                unlink(public_path($subProduct->thumbnail_image));
            }
            $file = $request->file('thumbnail_image');
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/'), $fileName);
            $validated['thumbnail_image'] = 'uploads/products/' . $fileName;
        } else {
            $validated['thumbnail_image'] = $subProduct->thumbnail_image;
        }

        // Slug update only if sub_product changed
        if ($validated['sub_product'] !== $subProduct->sub_product) {
            $slug = Str::slug($validated['sub_product']);
            $originalSlug = $slug;
            $counter = 1;
            while (SubProduct::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = "{$originalSlug}-{$counter}";
                $counter++;
            }
            $validated['slug'] = $slug;
        } else {
            $validated['slug'] = $subProduct->slug;
        }

        // Update the record
        $subProduct->update([
            'banner_title'    => $validated['banner_title'] ?? null,
            'banner_image'    => $validated['banner_image'],
            'product_id'      => $validated['product_id'],
            'application_id'  => $validated['application_type'],
            'category_id'     => $validated['parent_category'],
            'sub_product'     => $validated['sub_product'],
            'thumbnail_image' => $validated['thumbnail_image'],
            'slug'            => $validated['slug'],
            'modified_by'      => Auth::id(),
            'modified_at'      => Carbon::now(),
        ]);

        return redirect()
            ->route('manage-sub-product.index')
            ->with('message', 'Sub Product updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = SubProduct::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-sub-product.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }




}