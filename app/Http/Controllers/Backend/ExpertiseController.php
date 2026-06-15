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
use App\Models\Expertise;


class ExpertiseController extends Controller
{

    public function index()
    {
        $expertiseList = Expertise::wherenull('deleted_by')->get(); // Fetch all records
        return view('backend.about.expertise.index', compact('expertiseList'));
    }

    public function create(Request $request)
    {
        return view('backend.about.expertise.create');
    }

    public function store(Request $request)
    {
        // ✅ Validation rules & messages
        $validated = $request->validate(
            [
                'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB
                'heading'       => 'required|string|max:255',
                'extra_image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'heading_icon'  => 'required|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'description'   => 'required|string',
            ],
            [
                // Banner Image
                'banner_image.image'  => 'The banner image must be a valid image file.',
                'banner_image.mimes'  => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
                'banner_image.max'    => 'The banner image may not be greater than 2MB.',

                // Heading
                'heading.required'    => 'The heading field is required.',
                'heading.max'         => 'The heading may not be greater than 255 characters.',

                // Extra Image
                'extra_image.required'=> 'The extra image is required.',
                'extra_image.image'   => 'The extra image must be a valid image file.',
                'extra_image.mimes'   => 'The extra image must be a file of type: jpg, jpeg, png, webp.',
                'extra_image.max'     => 'The extra image may not be greater than 2MB.',

                // Heading Icon
                'heading_icon.required'=> 'The icon is required.',
                'heading_icon.mimes'   => 'The icon must be a file of type: jpg, jpeg, png, webp, svg.',
                'heading_icon.max'     => 'The icon may not be greater than 2MB.',

                // Description
                'description.required'=> 'The description field is required.',
            ]
        );

        try {
            // Initialize file variables
            $bannerImageName = null;
            $extraImageName  = null;
            $headingIconName = null;

            // ✅ Banner Image Upload
            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $bannerImageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/about'), $bannerImageName);
            }

            // ✅ Extra Image Upload
            if ($request->hasFile('extra_image')) {
                $extra = $request->file('extra_image');
                $extraImageName = time() . rand(1000, 9999) . '.' . $extra->getClientOriginalExtension();
                $extra->move(public_path('uploads/about'), $extraImageName);
            }

            // ✅ Heading Icon Upload
            if ($request->hasFile('heading_icon')) {
                $icon = $request->file('heading_icon');
                $headingIconName = time() . rand(10000, 99999) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('uploads/about'), $headingIconName);
            }

            // ✅ Save to database
            $expertise = new Expertise(); // Make sure your model is named correctly
            $expertise->banner_image  = $bannerImageName;
            $expertise->heading       = $validated['heading'];
            $expertise->extra_image   = $extraImageName;
            $expertise->heading_icon  = $headingIconName;
            $expertise->description   = $validated['description'];
            
            $expertise->meta_title   = $request->meta_title;
            $expertise->meta_description  = $request->meta_description;
            
            
            $expertise->cannonical       = $request->cannonical;
            $expertise->hreflang         = $request->hreflang;
            $expertise->og_tag           = $request->og_tag;
            $expertise->twitter_card_tag = $request->twitter_card_tag;
        
            
            $expertise->created_at    = Carbon::now();
            $expertise->created_by    = Auth::user()->id;
            $expertise->save();

            return redirect()->route('manage-expertise.index')
                            ->with('message', 'Expertise details saved successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $expertise = Expertise::findOrFail($id);
        // dd($expertise);
        return view('backend.about.expertise.edit', compact('expertise'));
    }

    public function update(Request $request, $id)
    {
        // ✅ Validation rules & messages
        $validated = $request->validate(
            [
                'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB
                'heading'       => 'required|string|max:255',
                'extra_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'heading_icon'  => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'description'   => 'required|string',
            ],
            [
                'banner_image.image'   => 'The banner image must be a valid image file.',
                'banner_image.mimes'   => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
                'banner_image.max'     => 'The banner image may not be greater than 2MB.',

                'heading.required'     => 'The heading field is required.',
                'heading.max'          => 'The heading may not be greater than 255 characters.',

                'extra_image.image'    => 'The image must be a valid image file.',
                'extra_image.mimes'    => 'The image must be a file of type: jpg, jpeg, png, webp.',
                'extra_image.max'      => 'The image may not be greater than 2MB.',

                'heading_icon.mimes'   => 'The icon must be a file of type: jpg, jpeg, png, webp, svg.',
                'heading_icon.max'     => 'The icon may not be greater than 2MB.',

                'description.required' => 'The description field is required.',
            ]
        );

        try {
            $expertise = Expertise::findOrFail($id);

            // Banner Image Upload
            if ($request->hasFile('banner_image')) {
                // Delete old file if exists
                if ($expertise->banner_image && file_exists(public_path('uploads/about/'.$expertise->banner_image))) {
                    unlink(public_path('uploads/about/'.$expertise->banner_image));
                }

                $image = $request->file('banner_image');
                $bannerImageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/about'), $bannerImageName);
                $expertise->banner_image = $bannerImageName;
            }

            // Extra Image Upload
            if ($request->hasFile('extra_image')) {
                if ($expertise->extra_image && file_exists(public_path('uploads/about/'.$expertise->extra_image))) {
                    unlink(public_path('uploads/about/'.$expertise->extra_image));
                }

                $extra = $request->file('extra_image');
                $extraImageName = time() . rand(1000, 9999) . '.' . $extra->getClientOriginalExtension();
                $extra->move(public_path('uploads/about'), $extraImageName);
                $expertise->extra_image = $extraImageName;
            }

            // Heading Icon Upload
            if ($request->hasFile('heading_icon')) {
                if ($expertise->heading_icon && file_exists(public_path('uploads/about/'.$expertise->heading_icon))) {
                    unlink(public_path('uploads/about/'.$expertise->heading_icon));
                }

                $icon = $request->file('heading_icon');
                $headingIconName = time() . rand(10000, 99999) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('uploads/about'), $headingIconName);
                $expertise->heading_icon = $headingIconName;
            }

            // Update other fields
            $expertise->heading     = $validated['heading'];
            $expertise->description = $validated['description'];
            $expertise->meta_title   = $request->meta_title;
            $expertise->meta_description  = $request->meta_description;
            
            $expertise->cannonical       = $request->cannonical;
            $expertise->hreflang         = $request->hreflang;
            $expertise->og_tag           = $request->og_tag;
            $expertise->twitter_card_tag = $request->twitter_card_tag;
            
            
            $expertise->modified_at  = Carbon::now();
            $expertise->modified_by  = Auth::user()->id;
            $expertise->save();

            return redirect()->route('manage-expertise.index')
                            ->with('message', 'Expertise details updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Expertise::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-expertise.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}