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
use App\Models\Advertise;


class AdvertiseController extends Controller
{

    public function index()
    {
        $products = Advertise::whereNull('deleted_by')->get();
        return view('backend.home.advertise.index', compact('products'));
    }
    
    public function create(Request $request)
    { 
        return view('backend.home.advertise.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'banner_title' => 'required|string|max:255',
            'video_upload' => 'required|mimes:mp4,webm,ogg|max:5120', 
        ], [
            'banner_title.required' => 'The banner title is required.',
            'video_upload.required' => 'Please upload a video.',
            'video_upload.mimes' => 'Only MP4, WebM, and OGG formats are allowed.',
            'video_upload.max' => 'The video must not be greater than 5MB.',
        ]);

        try {
            $videoPath = null;
            $originalVideoName = null;

            if ($request->hasFile('video_upload')) {
                $video = $request->file('video_upload');
                $originalVideoName = $video->getClientOriginalName(); 
                $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();
                
                $destinationPath = public_path('uploads/home/advertise');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $video->move($destinationPath, $videoName);

                $videoPath = 'uploads/home/advertise/' . $videoName;
            }


            Advertise::create([
                'banner_title'        => $validated['banner_title'],
                'video'               => $videoName,
                'original_video_name' => $originalVideoName,
                'created_at'          => Carbon::now(),
                'created_by'          => Auth::id(),
            ]);

            return redirect()->route('manage-advertise.index')->with('message', 'Advertisement created successfully.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit($id)
    {
        $banner_details = Advertise::findOrFail($id);
        return view('backend.home.advertise.edit', compact('banner_details'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'banner_title' => 'required|string|max:255',
            'video_upload' => 'nullable|mimes:mp4,webm,ogg|max:5120',
        ], [
            'banner_title.required' => 'The banner title is required.',
            'video_upload.mimes' => 'Only MP4, WebM, and OGG formats are allowed.',
            'video_upload.max' => 'The video must not be greater than 5MB.',
        ]);

        try {
            $advertise = Advertise::findOrFail($id);
            $videoName = $advertise->video; 
            $originalVideoName = $advertise->original_video_name;

            if ($request->hasFile('video_upload')) {

                // Remove old video if it exists
                $oldVideoPath = public_path('uploads/home/advertise/' . $advertise->video);
                if (file_exists($oldVideoPath)) {
                    @unlink($oldVideoPath);
                }

                $video = $request->file('video_upload');
                $originalVideoName = $video->getClientOriginalName();
                $videoName = time() . '_' . uniqid() . '.' . $video->getClientOriginalExtension();

                $destinationPath = public_path('uploads/home/advertise');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $video->move($destinationPath, $videoName);
            }

            $advertise->update([
                'banner_title'        => $validated['banner_title'],
                'video'               => $videoName,
                'original_video_name' => $originalVideoName,
                'modified_at'          => Carbon::now(),
                'modified_by'          => Auth::id(),
            ]);

            return redirect()->route('manage-advertise.index')->with('message', 'Advertisement updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Advertise::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-advertise.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
    
}