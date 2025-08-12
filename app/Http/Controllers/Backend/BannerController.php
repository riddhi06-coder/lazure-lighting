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
use App\Models\Banner;



class BannerController extends Controller
{

    public function index()
    {
        $banner = Banner::whereNull('deleted_by')->get(); 
        return view('backend.home.banner.index', compact('banner'));
    }
    

    public function create(Request $request)
    { 
        return view('backend.home.banner.create');
    }

        public function store(Request $request)
        {
            $request->validate([
                'banner_heading' => 'required|string|max:255',
                'banner_title' => 'required|string|max:255',
                'banner_image' => 'required|max:3072',  
            ], [
                'banner_heading.required' => 'The banner heading is required.',
                'banner_title.required' => 'The banner title is required.',
                'banner_image.required' => 'The banner image is required.',
                'banner_image.max' => 'The banner image must not be greater than 3MB.',
            ]);
        
            $imageName = null;
        
            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/home/banner'), $imageName);  
            }
        
            $banner = new Banner();
            $banner->banner_heading = $request->input('banner_heading');
            $banner->banner_title = $request->input('banner_title');
            $banner->banner_images = $imageName;  
            $banner->created_at = Carbon::now(); 
            $banner->created_by = Auth::user()->id;
            $banner->save();  
        
            return redirect()->route('manage-banner.index')->with('message', 'Banner has been successfully added!');
        }

    public function edit($id)
    {
        $banner_details = Banner::findOrFail($id);
        return view('backend.home.banner.edit', compact('banner_details'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'nullable|max:3072',  
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_title.required' => 'The banner title is required.',
            'banner_image.max' => 'The banner image must not be greater than 3MB.',
        ]);

        $banner = Banner::findOrFail($id);  

        $imageName = $banner->banner_images;  
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/uploads/home/banner'), $imageName);
        }

        $banner->banner_heading = $request->input('banner_heading');
        $banner->banner_title = $request->input('banner_title');
        $banner->banner_images = $imageName;  
        $banner->modified_at = Carbon::now();
        $banner->modified_by = Auth::user()->id; 
        $banner->save();

        return redirect()->route('manage-banner.index')->with('message', 'Banner has been successfully updated!');
    }


    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Banner::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-banner.index')->with('message', 'Banner Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}