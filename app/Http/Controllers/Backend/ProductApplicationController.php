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
use App\Models\ProductApplication;
use App\Models\Product;


class ProductApplicationController extends Controller
{

    public function index()
    {
        $products = ProductApplication::with('product')->whereNull('deleted_by')->get();
        return view('backend.product_app.index', compact('products'));
    }


    public function create(Request $request)
    {
        $product = Product::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('backend.product_app.create', compact('product'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'banner_title' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('product_applications', 'product_id')->whereNull('deleted_by'),
            ],
            'section_heading' => 'required|string|max:255',
            'section_desc' => 'required|string|max:1000',

            'on_off_status.*' => 'required|in:on,off',
            'on_off_image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

            'type.*' => 'required|string|max:255',
            'type_image.*' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ], [
            'banner_title.string' => 'Banner Title must be a valid string.',
            'banner_title.max' => 'Banner Title cannot exceed 255 characters.',

            'banner_image.image' => 'The Banner Image must be an image file.',
            'banner_image.mimes' => 'Only JPG, JPEG, PNG, or WEBP formats are allowed for Banner Image.',
            'banner_image.max' => 'Banner Image cannot exceed 2MB.',

            'product_id.required' => 'Please select a Product.',
            'product_id.exists' => 'Selected Product is invalid.',

            'section_heading.required' => 'Please enter a Section Heading.',
            'section_heading.string' => 'Section Heading must be a valid string.',
            'section_heading.max' => 'Section Heading cannot exceed 255 characters.',

            'section_desc.required' => 'Please enter a Section Description.',
            'section_desc.string' => 'Section Description must be a valid string.',
            'section_desc.max' => 'Section Description cannot exceed 1000 characters.',

            'on_off_status.*.required' => 'Please select On/Off Status.',
            'on_off_status.*.in' => 'Status must be either "on" or "off".',

            'on_off_image.*.required' => 'Please upload an On/Off Image.',
            'on_off_image.*.image' => 'Each On/Off Image must be an image file.',
            'on_off_image.*.mimes' => 'On/Off Image must be JPG, JPEG, PNG, or WEBP format.',
            'on_off_image.*.max' => 'On/Off Image cannot exceed 2MB.',

            'type.*.required' => 'Please enter a Title for Light Application Image.',
            'type.*.string' => 'Title must be a valid string.',
            'type.*.max' => 'Title cannot exceed 255 characters.',

            'type_image.*.required' => 'Please upload a Light Application Image.',
            'type_image.*.image' => 'Each Light Application Image must be an image file.',
            'type_image.*.mimes' => 'Light Application Image must be JPG, JPEG, PNG, WEBP, or SVG format.',
            'type_image.*.max' => 'Light Application Image cannot exceed 2MB.',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . '_' . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/banners'), $bannerImageName);
        } else {
            $bannerImageName = null;
        }

        // Handle On/Off Images
        $onOffImages = [];
        if ($request->has('on_off_status')) {
            foreach ($request->on_off_status as $index => $status) {
                if ($request->hasFile('on_off_image.' . $index)) {
                    $file = $request->file('on_off_image.' . $index);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/on_off_images'), $fileName);

                    $onOffImages[] = [
                        'status' => $status,
                        'image' => 'uploads/on_off_images/' . $fileName,
                    ];
                }
            }
        }

        // Handle Light Application Images
        $lightImages = [];
        if ($request->has('type')) {
            foreach ($request->type as $index => $title) {
                if ($request->hasFile('type_image.' . $index)) {
                    $file = $request->file('type_image.' . $index);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/light_images'), $fileName);

                    $lightImages[] = [
                        'type' => $title,
                        'image' => 'uploads/light_images/' . $fileName,
                    ];
                }
            }
        }

        // Store in database
        $app = new ProductApplication(); // Replace with your model name
        $app->banner_title = $request->banner_title;
        $app->banner_image = $bannerImageName ? 'uploads/banners/' . $bannerImageName : null;
        $app->product_id = $request->product_id;
        $app->section_heading = $request->section_heading;
        $app->section_desc = $request->section_desc;
        $app->on_off_images = json_encode($onOffImages);
        $app->light_images = json_encode($lightImages);
        
        $app->meta_title = $request->meta_title;
        $app->meta_description = $request->meta_description;
        
        $app->cannonical       = $request->cannonical;
        $app->hreflang         = $request->hreflang;
        $app->og_tag           = $request->og_tag;
        $app->twitter_card_tag = $request->twitter_card_tag;
        
        $app->created_by = Auth::id();
        $app->created_at = Carbon::now();
        $app->save();

        return redirect()->route('manage-apps.index')->with('message', 'Light Applications added successfully!');
    }

    public function edit($id)
    {
        $appIntro = ProductApplication::findOrFail($id);

        // Fetch products for dropdown
        $product = Product::orderBy('created_at', 'asc')->whereNull('deleted_by')->get();

        // Decode JSON for On/Off and Light Application Images
        $onOffImages = json_decode($appIntro->on_off_images, true) ?? [];
        $lightImages = json_decode($appIntro->light_images, true) ?? [];

        return view('backend.product_app.edit', compact('appIntro','product','onOffImages','lightImages'));
    }

    public function update(Request $request, $id)
    {
        $app = ProductApplication::findOrFail($id);

        // Validate the request
        $request->validate([
            'banner_title' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'product_id' => 'required|exists:products,id',
            'section_heading' => 'required|string|max:255',
            'section_desc' => 'required|string|max:1000',

            'on_off_status.*' => 'required|in:on,off',
            'on_off_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'type.*' => 'required|string|max:255',
            'type_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ], [
            'banner_title.string' => 'Banner Title must be a valid string.',
            'banner_title.max' => 'Banner Title cannot exceed 255 characters.',
            'banner_image.image' => 'The Banner Image must be an image file.',
            'banner_image.mimes' => 'Only JPG, JPEG, PNG, or WEBP formats are allowed for Banner Image.',
            'banner_image.max' => 'Banner Image cannot exceed 2MB.',
            'product_id.required' => 'Please select a Product.',
            'product_id.exists' => 'Selected Product is invalid.',
            'section_heading.required' => 'Please enter a Section Heading.',
            'section_heading.string' => 'Section Heading must be a valid string.',
            'section_heading.max' => 'Section Heading cannot exceed 255 characters.',
            'section_desc.required' => 'Please enter a Section Description.',
            'section_desc.string' => 'Section Description must be a valid string.',
            'section_desc.max' => 'Section Description cannot exceed 1000 characters.',
            'on_off_status.*.required' => 'Please select On/Off Status.',
            'on_off_status.*.in' => 'Status must be either "on" or "off".',
            'on_off_image.*.image' => 'Each On/Off Image must be an image file.',
            'on_off_image.*.mimes' => 'On/Off Image must be JPG, JPEG, PNG, or WEBP format.',
            'on_off_image.*.max' => 'On/Off Image cannot exceed 2MB.',
            'type.*.required' => 'Please enter a Title for Light Application Image.',
            'type.*.string' => 'Title must be a valid string.',
            'type.*.max' => 'Title cannot exceed 255 characters.',
            'type_image.*.image' => 'Each Light Application Image must be an image file.',
            'type_image.*.mimes' => 'Light Application Image must be JPG, JPEG, PNG, WEBP, or SVG format.',
            'type_image.*.max' => 'Light Application Image cannot exceed 2MB.',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName =time() . '_' . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/banners'), $bannerImageName);
            $app->banner_image = 'uploads/banners/' . $bannerImageName;
        }

        // Handle On/Off Images
        $onOffImages = [];
        if ($request->has('on_off_status')) {
            foreach ($request->on_off_status as $index => $status) {
                if ($request->hasFile('on_off_image.' . $index)) {
                    $file = $request->file('on_off_image.' . $index);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/on_off_images'), $fileName);
                    $imagePath = 'uploads/on_off_images/' . $fileName;
                } else {
                    // Keep existing image if no new file uploaded
                    $imagePath = $app->on_off_images ? json_decode($app->on_off_images, true)[$index]['image'] ?? null : null;
                }

                $onOffImages[] = [
                    'status' => $status,
                    'image' => $imagePath,
                ];
            }
        }

        // Handle Light Application Images
        $lightImages = [];
        if ($request->has('type')) {
            foreach ($request->type as $index => $title) {
                if ($request->hasFile('type_image.' . $index)) {
                    $file = $request->file('type_image.' . $index);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('uploads/light_images'), $fileName);
                    $imagePath = 'uploads/light_images/' . $fileName;
                } else {
                    $imagePath = $app->light_images ? json_decode($app->light_images, true)[$index]['image'] ?? null : null;
                }

                $lightImages[] = [
                    'type' => $title,
                    'image' => $imagePath,
                ];
            }
        }

        // Update other fields
        $app->banner_title = $request->banner_title;
        $app->product_id = $request->product_id;
        $app->section_heading = $request->section_heading;
        $app->section_desc = $request->section_desc;
        $app->on_off_images = json_encode($onOffImages);
        $app->light_images = json_encode($lightImages);
        $app->meta_title = $request->meta_title;
        $app->meta_description = $request->meta_description;
        
        $app->cannonical       = $request->cannonical;
        $app->hreflang         = $request->hreflang;
        $app->og_tag           = $request->og_tag;
        $app->twitter_card_tag = $request->twitter_card_tag;
        
        $app->modified_by = Auth::id();
        $app->modified_at = Carbon::now();
        $app->save();

        return redirect()->route('manage-apps.index')->with('message', 'Light Application updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ProductApplication::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-apps.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}