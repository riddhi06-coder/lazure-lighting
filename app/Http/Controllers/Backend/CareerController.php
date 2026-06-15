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


use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Models\Career;


class CareerController extends Controller
{

    public function index()
    {
        $career = Career::wherenull('deleted_by')->get(); 
        return view('backend.career.page.index', compact('career'));
    }

    public function create(Request $request)
    {
        return view('backend.career.page.create');
    }

    public function store(Request $request)
    {
    
        // ================= Validation =================
        $request->validate([
            'banner_heading'       => 'required|string|max:255',
            'banner_image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title'        => 'required|string|max:255',
            'section_image'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_description'  => 'required|string',
            'value_heading'        => 'required|string|max:255',
            'print_title.*'        => 'required|string|max:255',
            'print_icon.*'         => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'print_description.*'  => 'required|string',
            'join_heading'         => 'required|string|max:255',
            'section_icon'         => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'features.*'           => 'required|string|max:255',
            
            
            // New fields validation
            'role_heading'         => 'required|string|max:255',
            'roles_icon'           => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'role_description'     => 'required|string',
        
        ], [
            'banner_heading.required' => 'Banner Heading is required.',
            'banner_image.required'   => 'Banner Image is required.',
            'section_title.required'  => 'Section Heading is required.',
            'section_image.required'  => 'Section Image is required.',
            'section_description.required' => 'Section Description is required.',
            'value_heading.required' => 'Value Heading is required.',
            'print_title.*.required' => 'Print Title is required for each row.',
            'print_icon.*.required'  => 'Print Icon is required for each row.',
            'print_description.*.required' => 'Print Description is required for each row.',
            'join_heading.required'  => 'Join Heading is required.',
            'section_icon.required'  => 'Section Icon is required.',
            'features.*.required'    => 'Each feature is required.',
            'role_heading.required'  => 'Role Heading is required.',
            'roles_icon.required'    => 'Role Icon is required.',
            'role_description.required' => 'Role Description is required.',
        
        ]);
    
        // ================= Upload Function =================
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $fileName);
            return $fileName;
        };
    
        // ================= Store Data =================
        $career = new Career();
        $career->banner_heading       = $request->banner_heading;
        $career->banner_image         = $uploadFile($request->banner_image, 'uploads/career');
        $career->section_title        = $request->section_title;
        $career->section_image        = $uploadFile($request->section_image, 'uploads/career');
        $career->section_description  = $request->section_description;
        $career->value_heading        = $request->value_heading;
        
        $career->meta_title       = $request->meta_title;
        $career->meta_description = $request->meta_description;
        $career->cannonical       = $request->cannonical;
        $career->hreflang         = $request->hreflang;
        $career->og_tag           = $request->og_tag;
        $career->twitter_card_tag = $request->twitter_card_tag;

        // Our Values Table (JSON)
        $values = [];
        foreach ($request->print_title as $i => $title) {
            $values[] = [
                'title'       => $title,
                'icon'        => isset($request->print_icon[$i]) ? $uploadFile($request->print_icon[$i], 'uploads/career') : null,
                'description' => $request->print_description[$i],
            ];
        }
        $career->our_values = json_encode($values);
    
    
        // Join Features Table (JSON)
        $career->join_heading  = $request->join_heading;
        $career->section_icon  = $uploadFile($request->section_icon, 'uploads/career');
        $career->join_features = json_encode($request->features);
        
        
        // ================= New Role Fields =================
        $career->role_heading      = $request->role_heading;
        $career->roles_icon        = $uploadFile($request->roles_icon, 'uploads/career');
        $career->role_description  = $request->role_description;
    
    
        $career->created_by = Auth::id();
        $career->created_at = Carbon::now();
        $career->save();

        return redirect()->route('manage-career.index')->with('message', 'Career data stored successfully!');
    }
    
    public function edit($id)
    {
        $career = Career::findOrFail($id);
        return view('backend.career.page.edit', compact('career'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $career = Career::findOrFail($id);
    
        // ================= Validation =================
        $request->validate([
            'banner_heading'       => 'required|string|max:255',
            'banner_image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title'        => 'required|string|max:255',
            'section_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_description'  => 'required|string',
            'value_heading'        => 'required|string|max:255',
            'print_title.*'        => 'required|string|max:255',
            'print_icon.*'         => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'print_description.*'  => 'required|string',
            'join_heading'         => 'required|string|max:255',
            'section_icon'         => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'features.*'           => 'required|string|max:255',
            
            
            'role_heading'         => 'required|string|max:255',
            'roles_icon'           => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'role_description'     => 'required|string',
        
        ], [
            'banner_heading.required' => 'Banner Heading is required.',
            'section_title.required'  => 'Section Heading is required.',
            'section_description.required' => 'Section Description is required.',
            'value_heading.required' => 'Value Heading is required.',
            'print_title.*.required' => 'Print Title is required for each row.',
            'print_description.*.required' => 'Print Description is required for each row.',
            'join_heading.required'  => 'Join Heading is required.',
            'features.*.required'    => 'Each feature is required.',
        ]);
    
        // ================= Upload Function =================
        $uploadFile = function ($file, $folder) {
            $fileName = time() . rand(10, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path($folder), $fileName);
            return $fileName;
        };
    
        // ================= Update Main Data =================
        $career->banner_heading = $request->banner_heading;
        if ($request->hasFile('banner_image')) {
            $career->banner_image = $uploadFile($request->banner_image, 'uploads/career');
        }
    
        $career->section_title = $request->section_title;
        if ($request->hasFile('section_image')) {
            $career->section_image = $uploadFile($request->section_image, 'uploads/career');
        }
    
        $career->section_description = $request->section_description;
        $career->value_heading       = $request->value_heading;
        $career->meta_title       = $request->meta_title;
        $career->meta_description = $request->meta_description;
        $career->cannonical       = $request->cannonical;
        $career->hreflang         = $request->hreflang;
        $career->og_tag           = $request->og_tag;
        $career->twitter_card_tag = $request->twitter_card_tag;

    
    
        // ================= Our Values Table11 (JSON) =================
        $values = [];
        foreach ($request->print_title as $i => $title) {
            // If a new file is uploaded, use it
            if (isset($request->print_icon[$i])) {
                $icon = $uploadFile($request->print_icon[$i], 'uploads/career');
            } 
            // Otherwise, keep the old icon from hidden input
            else {
                $icon = $request->existing_print_icon[$i] ?? null;
            }
        
            $values[] = [
                'title' => $title,
                'icon'  => $icon,
                'description' => $request->print_description[$i],
            ];
        }
        
        $career->our_values = json_encode($values);



    
        // ================= Join Features Table (JSON) =================
        $career->join_heading = $request->join_heading;
        if ($request->hasFile('section_icon')) {
            $career->section_icon = $uploadFile($request->section_icon, 'uploads/career');
        }
        $career->join_features = json_encode($request->features);
        
        
        // ================= Role Section =================
        $career->role_heading = $request->role_heading;
        if ($request->hasFile('roles_icon')) {
            $career->roles_icon = $uploadFile($request->roles_icon, 'uploads/career');
        }
        $career->role_description = $request->role_description;


    
        $career->modified_by = Auth::id();
        $career->modified_at = Carbon::now();
        $career->save();
    
        return redirect()->route('manage-career.index')->with('message', 'Career data updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Career::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-career.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


    
}