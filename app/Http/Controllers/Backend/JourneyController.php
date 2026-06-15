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
use App\Models\OurJourney;


class JourneyController extends Controller
{

    public function index()
    {
        $journeys = OurJourney::wherenull('deleted_by')->get(); 
        return view('backend.about.journey.index', compact('journeys'));
    }

    public function create(Request $request)
    {
        return view('backend.about.journey.create');
    }

    public function store(Request $request)
    {
        // ✅ Validation rules & messages
        $validated = $request->validate(
            [
                'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB
                'year'         => 'required|string|max:10',
                'achievement'  => 'required|string|max:255',
                'heading_icon' => 'required|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'description'  => 'required|string',
            ],
            [
                // Banner Image
                'banner_image.image'  => 'The banner image must be a valid image file.',
                'banner_image.mimes'  => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
                'banner_image.max'    => 'The banner image may not be greater than 2MB.',

                // Year
                'year.required'       => 'The year field is required.',
                'year.max'            => 'The year may not be greater than 10 characters.',

                // Achievement
                'achievement.required'=> 'The achievement field is required.',
                'achievement.max'     => 'The achievement may not be greater than 255 characters.',

                // Heading Icon
                'heading_icon.required'=> 'The icon is required.',
                'heading_icon.mimes'   => 'The icon must be a file of type: jpg, jpeg, png, webp, svg.',
                'heading_icon.max'     => 'The icon may not be greater than 2MB.',

                // Description
                'description.required' => 'The description field is required.',
            ]
        );

        try {
            // Initialize file variables
            $bannerImageName = null;
            $headingIconName = null;

            // ✅ Banner Image Upload
            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $bannerImageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/about'), $bannerImageName);
            }

            // ✅ Heading Icon Upload
            if ($request->hasFile('heading_icon')) {
                $icon = $request->file('heading_icon');
                $headingIconName = time() . rand(1000, 9999) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('uploads/about'), $headingIconName);
            }

            // ✅ Save to database
            $journey = new OurJourney(); // Make sure your model is named correctly
            $journey->banner_image = $bannerImageName;
            $journey->year         = $validated['year'];
            $journey->achievement  = $validated['achievement'];
            $journey->heading_icon = $headingIconName;
            $journey->description  = $validated['description'];
            $journey->created_at   = Carbon::now(); 
            $journey->created_by   = Auth::user()->id;
            $journey->save();

            return redirect()->route('manage-our-journey.index')
                            ->with('message', 'Our Journey details saved successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $journey = OurJourney::findOrFail($id);
        return view('backend.about.journey.edit', compact('journey'));
    }


    public function update(Request $request, $id)
    {
        // ✅ Validation rules & messages
        $validated = $request->validate(
            [
                'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB
                'year'         => 'required|string|max:10',
                'achievement'  => 'required|string|max:255',
                'heading_icon' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:2048', // nullable on update
                'description'  => 'required|string',
            ],
            [
                'banner_image.image'  => 'The banner image must be a valid image file.',
                'banner_image.mimes'  => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
                'banner_image.max'    => 'The banner image may not be greater than 2MB.',

                'year.required'       => 'The year field is required.',
                'year.max'            => 'The year may not be greater than 10 characters.',

                'achievement.required'=> 'The achievement field is required.',
                'achievement.max'     => 'The achievement may not be greater than 255 characters.',

                'heading_icon.mimes'  => 'The icon must be a file of type: jpg, jpeg, png, webp, svg.',
                'heading_icon.max'    => 'The icon may not be greater than 2MB.',

                'description.required'=> 'The description field is required.',
            ]
        );

        try {
            $journey = OurJourney::findOrFail($id);

            // ✅ Banner Image Upload (replace old file if new uploaded)
            if ($request->hasFile('banner_image')) {
                // Delete old file
                if ($journey->banner_image && file_exists(public_path('uploads/about/'.$journey->banner_image))) {
                    unlink(public_path('uploads/about/'.$journey->banner_image));
                }

                $image = $request->file('banner_image');
                $bannerImageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/about'), $bannerImageName);
                $journey->banner_image = $bannerImageName;
            }

            // ✅ Heading Icon Upload (replace old file if new uploaded)
            if ($request->hasFile('heading_icon')) {
                if ($journey->heading_icon && file_exists(public_path('uploads/about/'.$journey->heading_icon))) {
                    unlink(public_path('uploads/about/'.$journey->heading_icon));
                }

                $icon = $request->file('heading_icon');
                $headingIconName = time() . rand(1000, 9999) . '.' . $icon->getClientOriginalExtension();
                $icon->move(public_path('uploads/about'), $headingIconName);
                $journey->heading_icon = $headingIconName;
            }

            // ✅ Update other fields
            $journey->year        = $validated['year'];
            $journey->achievement = $validated['achievement'];
            $journey->description = $validated['description'];
            $journey->modified_at  = Carbon::now();
            $journey->modified_by  = Auth::user()->id;

            $journey->save();

            return redirect()->route('manage-our-journey.index')
                            ->with('message', 'Our Journey details updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = OurJourney::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-our-journey.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}