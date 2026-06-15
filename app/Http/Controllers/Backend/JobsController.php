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
use App\Models\Jobs;


class JobsController extends Controller
{

    public function index()
    {
        $jobs = Jobs::whereNull('deleted_by')->orderBy('created_at', 'asc')->get();
        return view('backend.career.jobs.index', compact('jobs'));
    }

    public function create(Request $request)
    {
        return view('backend.career.jobs.create');
    }
    
    public function store(Request $request)
    {
        // ================= Validation =================
        $request->validate([
            'job_role'        => 'required|string|max:255',
            'job_location'    => 'required|string|max:255',
            'job_description' => 'required|string',
        ], [
            'job_role.required'        => 'Job Role is required.',
            'job_location.required'    => 'Job Location is required.',
            'job_description.required' => 'Job Description is required.',
        ]);
    
        // ================= Store Data =================
        $job = new Jobs(); // Assuming your model is named Job
        $job->job_role        = $request->job_role;
        $job->job_location    = $request->job_location;
        $job->job_description = $request->job_description;
        $job->created_by      = Auth::id(); 
        $job->created_at      = Carbon::now();
        $job->save();
    
        return redirect()->route('manage-jobs.index')->with('message', 'Job added successfully!');
    }

    public function edit($id)
    {
        $job = Jobs::findOrFail($id);
        return view('backend.career.jobs.edit', compact('job'));
    }
    
    public function update(Request $request, $id)
    {
        $job = Jobs::findOrFail($id);
    
        // ================= Validation =================
        $request->validate([
            'job_role'        => 'required|string|max:255',
            'job_location'    => 'required|string|max:255',
            'job_description' => 'required|string',
        ], [
            'job_role.required'        => 'Job Role is required.',
            'job_location.required'    => 'Job Location is required.',
            'job_description.required' => 'Job Description is required.',
        ]);
    
        // ================= Update Data =================
        $job->job_role        = $request->job_role;
        $job->job_location    = $request->job_location;
        $job->job_description = $request->job_description;
        $job->modified_by     = Auth::id(); 
        $job->modified_at     = Carbon::now();
        $job->save();
    
        return redirect()->route('manage-jobs.index')->with('message', 'Job updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Jobs::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-jobs.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}