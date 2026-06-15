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
use App\Models\LightApplications;
use App\Models\Category;


class LightApplicationController extends Controller
{

    public function index()
    {
        $applications = LightApplications::whereNull('deleted_by')
            ->orderBy('id', 'asc')
            ->get();
    
        // Fetch all category names for sub_category IDs
        $categories = Category::whereNull('deleted_by')->pluck('category', 'id')->toArray();
    
        // Map each application to include its category names
        $applications->transform(function ($app) use ($categories) {
            $subCategoryIds = $app->sub_category_id ? explode(',', $app->sub_category_id) : [];
            $app->sub_category_names = collect($subCategoryIds)
                ->map(fn($id) => $categories[$id] ?? null)
                ->filter()
                ->toArray();
            return $app;
        });
    
        return view('backend.light.index', compact('applications'));
    }

    public function create()
    {
        $categories = Category::wherenull('deleted_by')->pluck('category', 'id');
    
        return view('backend.light.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'light_application_type' => 'required|string|max:255',
            'sub_category'           => 'required|array', // <-- multiple selection
            'sub_category.*'         => 'integer|exists:category,id', // ensure valid IDs
            'thumbnail_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'light_application_type.required'  => 'The Light Application Type field is required.',
            'sub_category.required'            => 'Please select at least one Sub Category.',
            'sub_category.*.integer'           => 'Invalid Sub Category selected.',
            'sub_category.*.exists'            => 'Selected Sub Category does not exist.',
        
            'thumbnail_image.required'  => 'The Thumbnail Image is required.',
            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $thumbnailImage = $request->file('thumbnail_image');
        $thumbnailImageName = time() . '_' . uniqid() . '.' . $thumbnailImage->getClientOriginalExtension();
        $thumbnailPath = 'uploads/light-applications/';
        $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
        $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;

        $subCategories = implode(',', $validatedData['sub_category']);

        $slug = Str::slug($validatedData['light_application_type']);

        // Save to database
        LightApplications::create([
            'light_application_type' => $validatedData['light_application_type'],
            'sub_category_id'        => $subCategories,
            'thumbnail_image'  => $validatedData['thumbnail_image'],
            'slug'             => $slug,
            
            
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'cannonical'       => $request->cannonical,
            'hreflang'         => $request->hreflang,
            'og_tag'           => $request->og_tag,
            'twitter_card_tag' => $request->twitter_card_tag,
            
            'created_by'       => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);

        return redirect()->route('manage-light-application.index')->with('message', 'Light Application Type added successfully!');
    }

    public function edit($id)
    {
        $banner_details = LightApplications::findOrFail($id);
        $categories = Category::whereNull('deleted_by')->pluck('category', 'id');
    
        // Convert saved sub_category string to array and trim spaces
        $selectedCategories = $banner_details->sub_category_id
            ? array_map('trim', explode(',', $banner_details->sub_category_id))
            : [];
    
        return view('backend.light.edit', compact('banner_details','categories','selectedCategories'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'light_application_type' => [
                'required',
                'string',
                'max:255',
                Rule::unique('light_applications', 'light_application_type')->ignore($id),
            ],
            'thumbnail_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sub_category'     => 'required|array|min:1', 
        ];

        $messages = [
            'light_application_type.required' => 'The Light Application Type field is required.',
            'light_application_type.unique'   => 'This Light Application Type already exists.',

            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',
            'sub_category.required'           => 'Please select at least one Sub Category.',
            'sub_category.array'              => 'Invalid Sub Category selection.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $slug = Str::slug($validatedData['light_application_type']);

        // ✅ Make slug unique by appending a number if needed
        $originalSlug = $slug;
        $counter = 1;

        while (
            LightApplications::where('slug', $slug)
                ->where('id', '!=', $id) 
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Find the existing record
        $lightApplication = LightApplications::findOrFail($id);


         // Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . '_' . uniqid() . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/light-applications/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);

            // Delete old thumbnail if exists
            if ($lightApplication->thumbnail_image && file_exists(public_path($lightApplication->thumbnail_image))) {
                unlink(public_path($lightApplication->thumbnail_image));
            }

            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        } else {
            $validatedData['thumbnail_image'] = $lightApplication->thumbnail_image; // keep old image
        }


        // Convert sub_category array to comma-separated string
        $subCategoryString = implode(',', $validatedData['sub_category']);
    
    
        // Update fields
        $lightApplication->update([
            'light_application_type' => $validatedData['light_application_type'],
            'sub_category_id'           => $subCategoryString,
            'thumbnail_image'        => $validatedData['thumbnail_image'],
            'slug'                   => $slug,
            
            
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'cannonical'       => $request->cannonical,
            'hreflang'         => $request->hreflang,
            'og_tag'           => $request->og_tag,
            'twitter_card_tag' => $request->twitter_card_tag,
            
            'modified_by'            => Auth::id(),
            'modified_at'            => Carbon::now(),
        ]);

        return redirect()->route('manage-light-application.index')
            ->with('message', 'Light Application Type updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = LightApplications::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-light-application.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }



}