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
use App\Models\Contact;



class ContactController extends Controller
{

    public function index()
    {
        $contacts = Contact::all(); 
        return view('backend.contact.index', compact('contacts'));
    }
    

    public function create(Request $request)
    { 
        return view('backend.contact.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^\+?[0-9\s\-]{7,15}$/',
            'about' => 'required|string',

            // Locations array
            'locations' => 'required|array|min:1',
            'locations.*.name' => 'required|string',
            'locations.*.address' => 'required|string',
            'locations.*.gmap_url' => 'required|url',

            // Social media array
            'social_media' => 'required|array|min:1',
            'social_media.*.platform' => 'required',
            'social_media.*.link' => 'required|url',
        ], [
            // Email
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',

            // Contact number
            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Enter a valid contact number.',

            // About
            'about.required' => 'About Us content is required.',

            // Locations
            'locations.required' => 'At least one location is required.',
            'locations.*.name.required' => 'Each location must have a name.',
            'locations.*.address.required' => 'Each location must have an address.',
            'locations.*.gmap_url.required' => 'Each location must have a Gmap URL.',
            'locations.*.gmap_url.url' => 'Each Gmap URL must be a valid URL.',

            // Social Media
            'social_media.required' => 'At least one social media link is required.',
            'social_media.*.platform.required' => 'Each social media entry must have a selected platform.',
            'social_media.*.link.required' => 'Each social media entry must have a URL.',
            'social_media.*.link.url' => 'Each social media URL must be a valid link.',
        ]);


        Contact::create([
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contact_number'],
            'about' => $validatedData['about'],
            'locations' => json_encode($validatedData['locations']),
            'social_media' => json_encode($validatedData['social_media']),
            'inserted_by' => Auth::id(),
            'inserted_at' => Carbon::now(),
        ]);

        return redirect()->route('manage-contact.index')->with('message', 'Contact details saved successfully!');
    }

}