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
        $contacts = Contact::whereNull('deleted_by')->get(); 
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
            'iframe_url' => 'required|string',

            // Locations array
            'locations' => 'required|array|min:1',
            'locations.*.name' => 'required|string',
            'locations.*.address' => 'required|string',
            'locations.*.gmap_url' => 'required|url',

            // Social media array
            'social_media' => 'required|array|min:1',
            'social_media.*.platform' => 'required',
            'social_media.*.link' => 'required|url',
            
            // Images
            'image_one'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_two'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_three' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',


        ], [
            // Email
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',

            // Contact number
            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Enter a valid contact number.',

            // About
            'about.required' => 'About Us content is required.',
            'iframe_url.required' => 'Iframe URL is required.',
            'iframe_url.url' => 'Enter a valid Iframe URL.',


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
            
            
             // Image messages
            'image_one.required' => 'Image 1 is required.',
            'image_one.image' => 'Image 1 must be an image.',
            'image_one.mimes' => 'Image 1 must be jpg, jpeg, png, or webp.',
            'image_one.max' => 'Image 1 must be less than 2MB.',
        
            'image_two.required' => 'Image 2 is required.',
            'image_three.required' => 'Image 3 is required.',
            
        ]);
        
        
        $imageOneName = null;
        $imageTwoName = null;
        $imageThreeName = null;
        
        $uploadPath = public_path('uploads/contact');
        
        if ($request->hasFile('image_one')) {
            $image = $request->file('image_one');
            $imageOneName = time() . rand(10, 999) . '_1.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $imageOneName);
        }
        
        if ($request->hasFile('image_two')) {
            $image = $request->file('image_two');
            $imageTwoName = time() . rand(10, 999) . '_2.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $imageTwoName);
        }
        
        if ($request->hasFile('image_three')) {
            $image = $request->file('image_three');
            $imageThreeName = time() . rand(10, 999) . '_3.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $imageThreeName);
        }



        Contact::create([
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contact_number'],
            'iframe_url' => $validatedData['iframe_url'],
            'about' => $validatedData['about'],
            'locations' => json_encode($validatedData['locations']),
            'social_media' => json_encode($validatedData['social_media']),
            
            'image_one' => $imageOneName,
            'image_two' => $imageTwoName,
            'image_three' => $imageThreeName,
    
            'inserted_by' => Auth::id(),
            'inserted_at' => Carbon::now(),
        ]);

        return redirect()->route('manage-contact.index')->with('message', 'Contact details saved successfully!');
    }


    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->locations = json_decode($contact->locations, true);
        $contact->social_media = json_decode($contact->social_media, true);
        return view('backend.contact.edit', compact('contact'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'contact_number' => 'required|regex:/^\+?[0-9\s\-]{7,15}$/',
            'about' => 'required|string',
            'iframe_url' => 'required|string',

            // Locations array
            'locations' => 'required|array|min:1',
            'locations.*.name' => 'required|string',
            'locations.*.address' => 'required|string',
            'locations.*.gmap_url' => 'required|url',

            // Social media array
            'social_media' => 'required|array|min:1',
            'social_media.*.platform' => 'required',
            'social_media.*.link' => 'required|url',
            
            
            // Images (optional on update)
            'image_one'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_two'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_three' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            
        ], [
            // Email
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',

            // Contact number
            'contact_number.required' => 'Contact number is required.',
            'contact_number.regex' => 'Enter a valid contact number.',

            // About
            'about.required' => 'About Us content is required.',
            'iframe_url.required' => 'Iframe URL is required.',
            'iframe_url.url' => 'Enter a valid Iframe URL.',

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
            
             'image_one.mimes' => 'Image 1 must be jpg, jpeg, png, or webp.',
            'image_two.mimes' => 'Image 2 must be jpg, jpeg, png, or webp.',
            'image_three.mimes' => 'Image 3 must be jpg, jpeg, png, or webp.',
            'image_one.max' => 'Image 1 must be less than 2MB.',
            'image_two.max' => 'Image 2 must be less than 2MB.',
            'image_three.max' => 'Image 3 must be less than 2MB.',
        
        ]);

        $contact = Contact::findOrFail($id);
        
        
        $uploadPath = public_path('uploads/contact');

        // -------- IMAGE 1 --------
        if ($request->hasFile('image_one')) {
            if ($contact->image_one && file_exists($uploadPath.'/'.$contact->image_one)) {
                unlink($uploadPath.'/'.$contact->image_one);
            }
    
            $image = $request->file('image_one');
            $imageOneName = time().rand(10,999).'_1.'.$image->getClientOriginalExtension();
            $image->move($uploadPath, $imageOneName);
    
            $contact->image_one = $imageOneName;
        }
    
        // -------- IMAGE 2 --------
        if ($request->hasFile('image_two')) {
            if ($contact->image_two && file_exists($uploadPath.'/'.$contact->image_two)) {
                unlink($uploadPath.'/'.$contact->image_two);
            }
    
            $image = $request->file('image_two');
            $imageTwoName = time().rand(10,999).'_2.'.$image->getClientOriginalExtension();
            $image->move($uploadPath, $imageTwoName);
    
            $contact->image_two = $imageTwoName;
        }
    
        // -------- IMAGE 3 --------
        if ($request->hasFile('image_three')) {
            if ($contact->image_three && file_exists($uploadPath.'/'.$contact->image_three)) {
                unlink($uploadPath.'/'.$contact->image_three);
            }
    
            $image = $request->file('image_three');
            $imageThreeName = time().rand(10,999).'_3.'.$image->getClientOriginalExtension();
            $image->move($uploadPath, $imageThreeName);
    
            $contact->image_three = $imageThreeName;
        }



        $contact->update([
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contact_number'],
            'iframe_url' => $validatedData['iframe_url'],
            'about' => $validatedData['about'],
            'locations' => json_encode($validatedData['locations']),
            'social_media' => json_encode($validatedData['social_media']),
            'modified_by' => Auth::id(),
            'modified_at' => Carbon::now(),
        ]);

        return redirect()->route('manage-contact.index')->with('message', 'Contact details updated successfully!');
    }


     public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Contact::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-contact.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}