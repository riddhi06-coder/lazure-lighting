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
use App\Models\ManageNavigation;



class HomeNavigationsController extends Controller
{

    public function index()
    {
        $navigations = ManageNavigation::wherenull('deleted_by')->get();
    
        return view('backend.home.navigation.index', compact('navigations'));
    }
    
    public function create(Request $request)
    {
        return view('backend.home.navigation.create');
    }
    
    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'heading'     => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    
        // ✅ Image Upload (as per your method)
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/home/navigation/'), $imageName);
            $imagePath = 'uploads/home/navigation/' . $imageName;
        }
    
        // ✅ Store Data
        ManageNavigation::create([
            'heading'     => $request->heading,
            'description' => $request->description,
            'image'       => $imagePath,
            'created_by'       => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);
    
        // ✅ Redirect
        return redirect()->route('manage-navigations.index')->with('message', 'Data added successfully.');
    }
    
    public function edit($id)
    {
        $navigation = ManageNavigation::findOrFail($id);
        return view('backend.home.navigation.edit', compact('navigation'));
    }
    
    public function update(Request $request, $id)
    {
        // ✅ Validation
        $request->validate([
            'heading'     => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    
        $navigation = ManageNavigation::findOrFail($id);
    
        // ✅ Image Upload (same method as store)
        if ($request->hasFile('image')) {
    
            // Delete old image if exists
            if ($navigation->image && file_exists(public_path($navigation->image))) {
                unlink(public_path($navigation->image));
            }
    
            $image = $request->file('image');
            $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/home/navigation/'), $imageName);
            $navigation->image = 'uploads/home/navigation/' . $imageName;
        }
    
        // ✅ Update Data
        $navigation->heading     = $request->heading;
        $navigation->description = $request->description;
        $navigation->modified_by  = Auth::id();
        $navigation->modified_at  = Carbon::now();
        $navigation->save();
    
        // ✅ Redirect
        return redirect()
            ->route('manage-navigations.index')
            ->with('message', 'Data modified successfully.');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ManageNavigation::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-navigations.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}