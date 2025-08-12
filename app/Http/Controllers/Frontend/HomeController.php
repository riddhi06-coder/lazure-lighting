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
use App\Models\Product;
use App\Models\Applications;
use App\Models\Category;

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
        // dd($appIntros);
        foreach ($appIntros as $intro) {
            $intro->details = json_decode($intro->application_details, true);
            
        }
        $firstSection = $appIntros->take(2);
        $secondSection = $appIntros->skip(2);

        

        return view('frontend.index', compact('banners','featuredProducts','advertisement','appIntros','firstSection', 'secondSection','projectCategories','blogs'));
    }

    public function product_list()
    {
        $products = Product::wherenull('deleted_by')->get();
        $banner = Product::first();
        return view('frontend.products_list', compact('products','banner'));
    }

    public function application_list($application_type)
    {
        $application = Applications::where('slug', $application_type)->firstOrFail();
        $categories = DB::table('category')
            ->join('application_type', 'category.application_id', '=', 'application_type.id')
            ->where('application_type.slug', $application_type)
            ->wherenull('category.deleted_by')
            ->select('category.*')
            ->get();
    
        $banner = Category::first();

        return view('frontend.application_list', compact('application', 'categories','banner'));
    }




}