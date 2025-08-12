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
use App\Models\SubProduct;

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
        $products = DB::table('products as p')
            ->join('category as c', 'p.category_id', '=', 'c.id')
            ->join('application_type as a', 'c.application_id', '=', 'a.id')
            ->whereNull('p.deleted_by')
            ->select('p.*', 'a.application_type', 'a.slug as application_slug')  
            ->get()
            ->groupBy('application_type'); 

        $banner = Product::first();

        return view('frontend.products_list', compact('products', 'banner'));
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

    public function category_list($slug)
    {
        $category = DB::table('category as c')
            ->join('application_type as a', 'c.application_id', '=', 'a.id')
            ->select('c.*', 'a.application_type')
            ->where('c.slug', $slug)
            ->whereNull('c.deleted_by')
            ->first();

        if (!$category) {
            abort(404);
        }

        $banner = SubProduct::first();

        $products = DB::table('products')
            ->where('category_id', $category->id)
            ->whereNull('deleted_by')
            ->get();

        return view('frontend.category_listing', compact('category', 'products', 'banner'));
    }



    public function subProductDetail($application_slug, $product_slug)
    {
        // Find application by slug
        $application = ApplicationType::where('slug', $application_slug)->firstOrFail();

        // Find product by slug and ensure it belongs to that application via category
        $product = Product::where('slug', $product_slug)
                    ->whereHas('category', function($query) use ($application) {
                        $query->where('application_id', $application->id);
                    })
                    ->firstOrFail();

        // You can fetch subproducts or other data here if needed

        return view('frontend.subproduct_detail', compact('application', 'product'));
    }





}