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
use App\Models\Applications;
use App\Models\AppIntro;


class AppIntroController extends Controller
{

    public function index()
    {
        $applications = AppIntro::whereNull('deleted_by')
            ->with('applicationType:id,application_type') 
            ->get();

        return view('backend.home.application.index', compact('applications'));
    }

    public function create(Request $request)
    {
        $applications = Applications::whereNull('deleted_by')->get();

        return view('backend.home.application.create', compact('applications'));
    }

    public function store(Request $request)
    {
        // ✅ Validation Rules
        $rules = [
            'application_type'     => [
                'required',
                'exists:application_type,id',
                Rule::unique('app_intro', 'application_type_id')
            ],
            'banner_image'            => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'application_info'        => 'required|string',
            
            'print_title'             => 'required|array|min:1',
            'print_title.*'           => 'required|string|max:255',

            'print_icon'              => 'required|array|min:1',
            'print_icon.*'            => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:2048',

            'print_description'       => 'nullable|array|min:1',
            'print_description.*'     => 'nullable|string|max:500',
        ];

        // ✅ Custom Messages
        $messages = [
            'application_type.required' => 'Please select an application type.',
            'application_type.exists'   => 'Selected application type does not exist.',

            'application_type.unique' => 'This application type is already added.',
            'application_type.exists' => 'Invalid application type selected.',

            'banner_image.required'     => 'Please upload a banner image.',
            'banner_image.image'        => 'Banner must be an image file.',
            'banner_image.mimes'        => 'Banner must be jpg, jpeg, png, or webp format.',
            'banner_image.max'          => 'Banner image must not exceed 2MB.',

            'application_info.required' => 'Please enter application information.',

            'print_title.required'      => 'Please enter at least one title.',
            'print_title.*.required'    => 'Each title is required.',
            'print_title.*.max'         => 'Title must not exceed 255 characters.',

            'print_icon.*.mimes'        => 'Icons must be in jpg, jpeg, png, svg or webp format.',
            'print_icon.*.max'          => 'Each icon must not exceed 2MB.',

            'print_description.*.max'      => 'Description must not exceed 500 characters.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // ✅ Handle Banner Image Upload (Custom Naming)
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/home/banner/'), $bannerImageName);
            $bannerImagePath = 'uploads/home/banner/' . $bannerImageName;
        }

        // ✅ Handle Multiple Icon Uploads (Custom Naming) & Build JSON
        $applicationDetails = [];
        foreach ($request->print_title as $index => $title) {
            $iconPath = null;
            if (isset($request->print_icon[$index]) && $request->file('print_icon')[$index]) {
                $iconFile = $request->file('print_icon')[$index];
                $iconName = time() . rand(10, 999) . '.' . $iconFile->getClientOriginalExtension();
                $iconFile->move(public_path('uploads/home/banner/'), $iconName);
                $iconPath = 'uploads/home/banner/' . $iconName;
            }

            $applicationDetails[] = [
                'title'       => $title,
                'icon'        => $iconPath,
                'description' => $request->print_description[$index],
            ];
        }

        // ✅ Save to Database
        AppIntro::create([
            'application_type_id' => $request->application_type,
            'banner_image'        => $bannerImagePath,
            'application_info'    => $request->application_info,
            'application_details' => json_encode($applicationDetails),
            'created_by'       => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);

        return redirect()->route('manage-app-intro.index')->with('message', 'Application intro created successfully.');
    }

    public function edit($id)
    {
        $appIntro = AppIntro::findOrFail($id);
        $applications = Applications::whereNull('deleted_by')->get();

        return view('backend.home.application.edit', compact('appIntro', 'applications'));
    }

    public function update(Request $request, $id)
    {
        $appIntro = AppIntro::findOrFail($id);

        // ✅ Validation Rules (ignore current ID for unique check)
        $rules = [
            'application_type'     => [
                'required',
                'exists:application_type,id',
                Rule::unique('app_intro', 'application_type_id')->ignore($id)
            ],
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'application_info'     => 'required|string',
            
            'print_title'          => 'required|array|min:1',
            'print_title.*'        => 'required|string|max:255',

            'print_icon'           => 'nullable|array|min:1',
            'print_icon.*'         => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:2048',

            'print_description'    => 'nullable|array|min:1',
            'print_description.*'  => 'nullable|string|max:500',
        ];

        $messages = [
            'application_type.unique' => 'This application type is already added.',
            'banner_image.mimes'      => 'Banner must be jpg, jpeg, png, or webp format.',
            'print_icon.*.mimes'      => 'Icons must be in jpg, jpeg, png, svg or webp format.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // ✅ Handle Banner Image
        $bannerImagePath = $appIntro->banner_image;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/home/banner/'), $bannerImageName);
            $bannerImagePath = 'uploads/home/banner/' . $bannerImageName;
        }

        // ✅ Decode old application details to keep existing icons if not replaced
        $oldDetails = json_decode($appIntro->application_details, true) ?? [];

        $applicationDetails = [];
        foreach ($request->print_title as $index => $title) {
            $iconPath = $oldDetails[$index]['icon'] ?? null;

            if (isset($request->print_icon[$index]) && $request->file('print_icon')[$index]) {
                $iconFile = $request->file('print_icon')[$index];
                $iconName = time() . rand(10, 999) . '.' . $iconFile->getClientOriginalExtension();
                $iconFile->move(public_path('uploads/home/banner/'), $iconName);
                $iconPath = 'uploads/home/banner/' . $iconName;
            }

            $applicationDetails[] = [
                'title'       => $title,
                'icon'        => $iconPath,
                'description' => $request->print_description[$index] ?? null,
            ];
        }

        // ✅ Update database
        $appIntro->update([
            'application_type_id' => $request->application_type,
            'banner_image'        => $bannerImagePath,
            'application_info'    => $request->application_info,
            'application_details' => json_encode($applicationDetails),
            'modified_by'         => Auth::id(),
            'modified_at'         => Carbon::now(),
        ]);

        return redirect()->route('manage-app-intro.index')
                        ->with('message', 'Application intro updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = AppIntro::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-app-intro.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}