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
use App\Models\Applications;


class ApplicationController extends Controller
{

    public function index()
    {
        $applications = Applications::orderBy('id', 'asc')->wherenull('deleted_by')->get();
        return view('backend.product.application.index', compact('applications'));
    }

    public function create(Request $request)
    { 
        return view('backend.product.application.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'banner_title'      => 'nullable|string|max:255',
            'banner_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'application_type'  => 'required|string|max:255',
        ];

        $messages = [
            'banner_image.image'        => 'The uploaded file must be an image.',
            'banner_image.mimes'        => 'Allowed image formats are jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The image size must be less than 2MB.',
            'application_type.required' => 'The Application Type is required.',
        ];

        $validatedData = $request->validate($rules, $messages);

        if ($request->hasFile('banner_image')) {
            $image      = $request->file('banner_image');
            $imageName  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath  = 'uploads/products/';
            $image->move(public_path($imagePath), $imageName);
            $validatedData['banner_image'] = $imagePath . $imageName;
        } else {
            $validatedData['banner_image'] = null;
        }

        $slug = Str::slug($validatedData['application_type']);

        Applications::create([
            'banner_title'     => $validatedData['banner_title'],
            'banner_image'     => $validatedData['banner_image'],
            'application_type' => $validatedData['application_type'],
            'slug'             => $slug,
            'created_at'       => Carbon::now(),
            'created_by'       => Auth::id(),
        ]);

        return redirect()->route('manage-application.index')->with('message', 'Application data saved successfully!');
    }

    public function edit($id)
    {
        $banner_details = Applications::findOrFail($id);
        return view('backend.product.application.edit', compact('banner_details'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'banner_title'      => 'nullable|string|max:255',
            'banner_image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'application_type'  => 'required|string|max:255',
        ];

        $messages = [
            'banner_image.image'        => 'The uploaded file must be an image.',
            'banner_image.mimes'        => 'Allowed image formats are jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The image size must be less than 2MB.',
            'application_type.required' => 'The Application Type is required.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $application = Applications::findOrFail($id);

        if ($request->hasFile('banner_image')) {
            $image      = $request->file('banner_image');
            $imageName  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath  = 'uploads/products/';
            $image->move(public_path($imagePath), $imageName);
            $validatedData['banner_image'] = $imagePath . $imageName;

            // Optionally delete the old image if exists
            if ($application->banner_image && file_exists(public_path($application->banner_image))) {
                unlink(public_path($application->banner_image));
            }
        } else {
            // Retain old image if no new image uploaded
            $validatedData['banner_image'] = $application->banner_image;
        }

        $slug = Str::slug($validatedData['application_type']);

        $application->update([
            'banner_title'     => $validatedData['banner_title'],
            'banner_image'     => $validatedData['banner_image'],
            'application_type' => $validatedData['application_type'],
            'slug'             => $slug,
            'modified_at'       => Carbon::now(),
            'modified_by'       => Auth::id(),
        ]);

        return redirect()->route('manage-application.index')->with('message', 'Application updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Applications::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-application.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
    

}