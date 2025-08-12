<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Models\Banner;
use App\Models\Featured;
use App\Models\Advertise;
use App\Models\AppIntro;
use App\Models\ProjectCategory;
use App\Models\Blog;

class HomeController extends Controller
{

    // === Home
    public function home(Request $request)
    {
        $banners = Banner::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        $featuredProducts = Featured::orderBy('created_at', 'asc')->whereNull('deleted_by')->get();
        $advertisement = Advertise::orderBy('created_at', 'asc')->whereNull('deleted_by')->first(); 
        $projectCategories = ProjectCategory::whereNull('deleted_by')->get();
        $blogs = Blog::whereNull('deleted_by')->get();


        $appIntros = AppIntro::with('applicationType')->get();
        foreach ($appIntros as $intro) {
            $intro->details = json_decode($intro->application_details, true);
            
        }
        $firstSection = $appIntros->take(2);
        $secondSection = $appIntros->skip(2);

        

        return view('frontend.index', compact('banners','featuredProducts','advertisement','appIntros','firstSection', 'secondSection','projectCategories','blogs'));
    }

}