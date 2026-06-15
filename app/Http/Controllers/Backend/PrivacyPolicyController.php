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
use App\Models\User;
use App\Models\PrivacyPolicy;



class PrivacyPolicyController extends Controller
{

    public function index()
    {
        $terms = PrivacyPolicy::orderBy('id', 'asc')->wherenull('deleted_by')->get();
        return view('backend.privacy.index', compact('terms'));
    }
    
    public function create(Request $request)
    { 
        return view('backend.privacy.create');
    }
    
    public function store(Request $request)
    {
        try {
            // ✅ Validate input
            $validated = $request->validate([
                'banner_heading'   => 'nullable|string|max:255',
                'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'effective_date'  => 'nullable|date',

                'title'            => 'required|string|max:255',
                'description'      => 'required|string|max:5000',
            ], [
                'banner_heading.max'       => 'Banner Heading must not exceed 255 characters.',
                'image.image'              => 'Please upload a valid Banner image.',
                'image.mimes'              => 'Banner image must be a file of type: jpg, jpeg, png, webp, svg.',
                'image.max'                => 'Banner image size must not exceed 2MB.',


                'title.required'           => 'Title is required.',
                'title.max'                => 'Title must not exceed 255 characters.',
                'description.required'     => 'Description is required.',
                'description.max'          => 'Description must not exceed 5000 characters.',
            ]);

            // ✅ Handle Banner Image Upload
            $bannerName = null;
            if ($request->hasFile('image')) {
                $banner = $request->file('image');
                $bannerName = time() . '_' . rand(10, 999) . '.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('uploads/privacy'), $bannerName);
            }
            
            // ✅ Save Record to Database
            $sports = new PrivacyPolicy();
            $sports->banner_heading = $validated['banner_heading'] ?? null;
            $sports->banner_image   = $bannerName;
            $sports->effective_date = $validated['effective_date'] ?? null;
            $sports->title          = $validated['title'];
            $sports->description    = $validated['description'];
            $sports->created_by     = Auth::id();
            $sports->created_at     = Carbon::now();
            $sports->save();

            return redirect()->route('manage-privacy-policy.index')
                            ->with('message', 'Policy added successfully.');

        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve; // Let Laravel handle validation errors

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! ' . $e->getMessage())
                        ->withInput();
        }
    }
    
    public function edit($id)
    {
        $terms = PrivacyPolicy::findOrFail($id);
        return view('backend.privacy.edit', compact('terms'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $term = PrivacyPolicy::findOrFail($id);
    
            // ✅ Validate input
            $validated = $request->validate([
                'banner_heading'   => 'nullable|string|max:255',
                'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
                'effective_date'   => 'nullable|date',
    
                'title'            => 'required|string|max:255',
                'description'      => 'required|string|max:5000',
            ], [
                'banner_heading.max' => 'Banner Heading must not exceed 255 characters.',
                'image.image'        => 'Please upload a valid Banner image.',
                'image.mimes'        => 'Banner image must be a file of type: jpg, jpeg, png, webp, svg.',
                'image.max'          => 'Banner image size must not exceed 2MB.',
    
                'title.required'     => 'Title is required.',
                'title.max'          => 'Title must not exceed 255 characters.',
                'description.required' => 'Description is required.',
                'description.max'    => 'Description must not exceed 5000 characters.',
            ]);
    
            // ✅ Handle Banner Image Upload
            if ($request->hasFile('image')) {
                $banner = $request->file('image');
                $bannerName = time() . '_' . rand(10, 999) . '.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('uploads/privacy'), $bannerName);
    
                // Delete old banner image if exists
                if ($term->banner_image && file_exists(public_path('uploads/privacy/' . $term->banner_image))) {
                    @unlink(public_path('uploads/privacy/' . $term->banner_image));
                }
    
                $term->banner_image = $bannerName;
            }
    
            // ✅ Update other fields
            $term->banner_heading  = $validated['banner_heading'] ?? $term->banner_heading;
            $term->effective_date  = $validated['effective_date'] ?? $term->effective_date;
            $term->title           = $validated['title'];
            $term->description     = $validated['description'];
            $term->modified_by      = Auth::id();
            $term->modified_at      = Carbon::now();
            $term->save();
    
            return redirect()->route('manage-privacy-policy.index')
                             ->with('message', 'Policy updated successfully.');
    
        } catch (\Illuminate\Validation\ValidationException $ve) {
            throw $ve; // Let Laravel handle validation errors
    
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong! ' . $e->getMessage())
                         ->withInput();
        }
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = PrivacyPolicy::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-privacy-policy.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}
