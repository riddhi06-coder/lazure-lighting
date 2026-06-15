<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
use App\Models\ModelDetail;
use App\Models\AboutUs;
use App\Models\OurJourney;
use App\Models\Expertise;
use App\Models\ProductApplication;
use App\Models\LightApplications;
use App\Models\BuiltToSuit;
use App\Models\Project;
use App\Models\ProjectsDetails;
use App\Models\Clientele;
use App\Models\Contact;
use App\Models\TermsConditions;
use App\Models\PrivacyPolicy;
use App\Models\Career;
use App\Models\Jobs;
use App\Models\BlogDetails;
use App\Models\BuiltToSuitGallery;
use App\Models\Brochure;
use App\Models\Catalog;
use App\Models\IndividualCatalog;
use App\Models\ManageNavigation;


class HomeController extends Controller
{

    // === Home
    public function home(Request $request)
    {
        $banners = Banner::orderBy('priority', 'asc')->wherenull('deleted_by')->get();
        $featuredProducts = Featured::orderBy('created_at', 'asc')->whereNull('deleted_by')->get();
        $advertisement = Advertise::orderBy('created_at', 'asc')->whereNull('deleted_by')->first(); 
        $projectCategories = ProjectCategory::whereNull('deleted_by')->get();
        $blogs = Blog::whereNull('deleted_by')->get();
        $clienteles = Clientele::whereNull('deleted_by')->get();

        // $appIntros = AppIntro::with('applicationType')->get();
        // // dd($appIntros);
        // foreach ($appIntros as $intro) {
        //     $intro->details = json_decode($intro->application_details, true);
            
        // }
        // // dd($appIntros);
        // $firstSection = $appIntros->take(2);
        // $secondSection = $appIntros->skip(2);
        
        
            $appIntros = AppIntro::with('applicationType')->get();

        // Fetch categories once
        $categories = DB::table('category')
            ->whereNull('deleted_by')
            ->select('category', 'slug')
            ->get();
    
        foreach ($appIntros as $intro) {
    
            $details = json_decode($intro->application_details, true) ?? [];
    
            $updatedDetails = [];
    
            foreach ($details as $detail) {
    
                $matchedCategory = $categories->first(function ($cat) use ($detail) {
                    return strtolower(trim($cat->category)) === strtolower(trim($detail['title']));
                });
    
                $detail['slug'] = $matchedCategory->slug
                    ?? \Illuminate\Support\Str::slug($detail['title']);
    
                $updatedDetails[] = $detail;
            }
    
            $intro->details = $updatedDetails;
        }
    
        $firstSection = $appIntros->take(2);
        $secondSection = $appIntros->skip(2);
    

        $navigation = ManageNavigation::whereNull('deleted_by')->get();

        return view('frontend.index', compact('banners','featuredProducts','advertisement','appIntros','firstSection', 'secondSection','projectCategories','blogs','clienteles','navigation'));
    }

    // === Product List
    public function product_list()
    {
        // dd('wjdhgfdefgr');
        // $products = DB::table('products as p')
        //     ->join('category as c', 'p.category_id', '=', 'c.id')
        //     ->join('application_type as a', 'c.application_id', '=', 'a.id')
        //     ->whereNull('p.deleted_by')
        //     ->select('p.*', 'a.application_type', 'a.slug as application_slug')  
        //     ->get()
        //     ->groupBy('application_type'); 


        $products = DB::table('category as c')
                ->join('application_type as a', 'c.application_id', '=', 'a.id')
                ->whereNull('c.deleted_by')
                ->select('c.*','c.id', 'c.category', 'a.application_type', 'a.slug as application_slug')
                ->get()
                ->groupBy('application_type');

        // dd($products);

        $banner = Product::first();

        return view('frontend.products_list', compact('products', 'banner'));
    }

    // === Application List
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

    // === Category List
    public function category_list($slug)
    {
        $category = DB::table('category as c')
            ->join('application_type as a', 'c.application_id', '=', 'a.id')
            ->select('c.*', 'a.application_type')
            ->where('c.slug', $slug)
            ->whereNull('c.deleted_by')
            ->first();
        // dd($category);

        if (!$category) {
            abort(404);
        }

        $banner = SubProduct::first();

        // $products = DB::table('products as p')
        //     ->join('category as c', 'p.category_id', '=', 'c.id')
        //     ->join('application_type as a', 'c.application_id', '=', 'a.id')
        //     ->select('p.*', 'a.slug as application_slug')
        //     ->where('p.category_id', $category->id)
        //     ->whereNull('p.deleted_by')
        //     ->get();


        $products = DB::table('products as p')
            ->join('category as c', 'p.category_id', '=', 'c.id')
            ->join('application_type as a', 'c.application_id', '=', 'a.id')
            ->join('sub_products as sp', function ($join) {
                $join->on('p.id', '=', 'sp.product_id')
                    ->whereNull('sp.deleted_by');
            })
            ->select(
                'p.id as product_id',
                'p.product',
                'p.thumbnail_image',
                'p.slug as product_slug',
                'a.slug as application_slug',
                'sp.id as sub_product_id',
                'sp.sub_product',
                'sp.slug as sub_product_slug',
                'sp.thumbnail_image as sub_thumbnail'
            )
            ->where('p.category_id', $category->id)
            ->whereNull('p.deleted_by')
            ->get()
            ->groupBy('product'); 

        // dd($products);


        return view('frontend.category_listing', compact('category', 'products', 'banner'));
    }

    // === Sub Product List
    public function subProductDetail($application_slug, $category_slug, $product_slug)
    {
        // Fetch first banner (if needed globally)
        $banner = SubProduct::first();

        // Get Application
        $application = Applications::where('slug', $application_slug)->firstOrFail();

        // Get SubProduct by slug and ensure its application_id contains the application
        $product = SubProduct::where('slug', $product_slug)
                    ->whereRaw("FIND_IN_SET(?, application_id)", [$application->id])
                    ->firstOrFail();
                    
                    
        $category = DB::table('category')
                ->where('id', $product->category_id)
                ->first();

        // Get Parent Product
        $product1 = Product::where('id', $product->product_id)->firstOrFail();

        // Get SubProducts under same Application & Product (comma-separated application_id)
        $subproducts = SubProduct::whereRaw("FIND_IN_SET(?, application_id)", [$application->id])
                        ->where('product_id', $product->product_id)
                        ->whereNull('deleted_by')
                        ->get();
        //  dd($subproducts);               
    

        // ðŸ”¹ Fetch sub_product_details if exists
        $subProductDetails = DB::table('sub_products_details')
                            ->where('sub_product_id', $product->id)
                            ->first();
                            
            // dd($subProductDetails);

        // Related Products (exclude current product)
        $relatedProducts = SubProduct::whereRaw("FIND_IN_SET(?, application_id)", [$application->id])
                        ->where('product_id', $product->product_id)
                        ->where('id', '!=', $product->id)
                        ->whereNull('deleted_by')
                        ->get();



        // Fetch Model Details for this SubProduct
        $modelDetails = ModelDetail::where('sub_product_id', $product->id)->get();
        
         // ✅ Check if Try It Out button should show
        $showTryItOut = DB::table('product_applications')
                        ->where('product_id', $product1->id)
                        ->exists();

        return view('frontend.subproduct_detailed', compact(
            'application',
            'product',
            'subproducts',
            'banner',
            'product1',
            'subProductDetails',
            'relatedProducts','modelDetails','showTryItOut','category'
        ));
    }

    // For detailed Page filter options
    public function filterModelDetails(Request $request)
    {
        $query = ModelDetail::where('sub_product_id', $request->sub_product_id);

        if ($request->size) $query->where('size', $request->size);
        if ($request->wattage) $query->where('wattage', $request->wattage);
        if ($request->lumens) $query->where('lumens', $request->lumens);
        if ($request->cct) $query->where('cct', $request->cct);
        if ($request->cri) $query->where('cri', $request->cri);
        if ($request->beam_angle) $query->where('beam_angle', $request->beam_angle);

        $filtered = $query->get();

        // Build table rows
        $tableRows = '';
        foreach($filtered as $detail){
            $tableRows .= '<tr>
                <th scope="row"><img src="'.asset($detail->product_image).'" style="height:100px;width:100px"></th>
                <td>'.$detail->model_name.'</td>
                <td>'.$detail->model_no.'</td>
                <td>'.$detail->size.'</td>
                <td>'.$detail->wattage.'</td>
                <td>'.$detail->lumens.'</td>
                <td>'.$detail->cct.'</td>
                <td>'.$detail->cri.'</td>
                <td>'.$detail->beam_angle.'</td>
                <td>'.$detail->accessories.'</td>
                <td>'.$detail->dimming_options.'</td>
                <td>'.(!empty($detail->specssheet) ? '<a class="download-pdf" href="'.asset($detail->specssheet).'" download>Download</a>' : '-').'</td>
                <td>'.(!empty($detail->drawings_2d) ? '<a class="download-pdf" href="'.asset($detail->drawings_2d).'" download>Download</a>' : '-').'</td>
                <td>'.(!empty($detail->drawings_3d) ? '<a class="download-pdf" href="'.asset($detail->drawings_3d).'" download>Download</a>' : '-').'</td>
                <td>'.(!empty($detail->installation_manual) ? '<a class="download-pdf" href="'.asset($detail->installation_manual).'" download>Download</a>' : '-').'</td>
            </tr>';
        }

        return response()->json([
            'size'       => $filtered->pluck('size')->unique()->filter()->values(),
            'wattage'    => $filtered->pluck('wattage')->unique()->filter()->values(),
            'lumens'     => $filtered->pluck('lumens')->unique()->filter()->values(),
            'cct'        => $filtered->pluck('cct')->unique()->filter()->values(),
            'cri'        => $filtered->pluck('cri')->unique()->filter()->values(),
            'beam_angle' => $filtered->pluck('beam_angle')->unique()->filter()->values(),
            'tableRows'  => $tableRows
        ]);
    }

    //===== About Us
    public function about_lazure(Request $request)
    {
        $about_us = AboutUs::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        $banner = AboutUs::first(); 
        return view('frontend.about_us', compact('about_us','banner'));
    }

     //===== Our Journey
    public function our_journey(Request $request)
    {
        $our_journey = OurJourney::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        $banner = OurJourney::first(); 
        return view('frontend.our_journey', compact('our_journey','banner'));
    }

     //===== Engineering Expertise
    public function engineering_expertise(Request $request)
    {
        $engineering_expertise = Expertise::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();

        $engineering_expertise1 = Expertise::orderBy('created_at', 'asc')->wherenull('deleted_by')->first();
        $banner = Expertise::first(); 
        return view('frontend.engineering_expertise', compact('engineering_expertise','banner','engineering_expertise1'));
    }

    //===== Product Applications
    // public function product_applications(Request $request)
    // {
    //     $product_applications = Product::whereNull('deleted_by')
    //         ->whereHas('applications', function ($query) {
    //             $query->whereNull('deleted_by'); 
    //         })
    //         ->orderBy('created_at', 'asc')
    //         ->get()
    //         ->groupBy('product'); 

    //     return view('frontend.product_applications', compact('product_applications'));
    // }
    
    public function product_applications(Request $request)
    {
        $products = Product::whereNull('deleted_by')
            ->whereHas('applications', function ($query) {
                $query->whereNull('deleted_by'); 
            })
            ->orderBy('created_at', 'asc')
            ->get();
            
       
    
        // Fetch all application types
        $application_types = Applications::pluck('application_type', 'id')->toArray();
    

     
        // Group products by each application type separately
        $product_applications = [];
    
        foreach ($products as $product) {
            // Split product application_ids if multiple
            $appIds = explode(',', $product->application_id);
    
            foreach ($appIds as $id) {
                $id = trim($id);
                if (!isset($product_applications[$id])) {
                    $product_applications[$id] = collect();
                }
                $product_applications[$id]->push($product);
            }
        }
        
        
      $productApplication_seo = ProductApplication::whereNull('deleted_by')
                        ->first();

    
        return view('frontend.product_applications', compact('product_applications', 'application_types','productApplication_seo'));
    }



    //===== Product Applications Details
    public function product_applications_details($slug)
    {
        // dd($slug);

        // First, find the product by slug
        $product = Product::where('slug', $slug)
                    ->whereNull('deleted_by')
                    ->firstOrFail();
        // dd($product);

        // Then fetch the related product application
        $productApplication = ProductApplication::where('product_id', $product->id)
                                    ->whereNull('deleted_by')
                                    ->first();

          $productApplicationbanner = ProductApplication::whereNull('deleted_by')
                                    ->first();
        // dd($productApplication);

        // Pass both product and application data to the view
        return view('frontend.product_application_detail', compact('product', 'productApplication','productApplicationbanner'));
    }

    //===== light_applications_listing
    public function light_applications_listing(Request $request)
    {
        $light_apps_listing = LightApplications::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        return view('frontend.light_apps_listing', compact('light_apps_listing'));
    }

    //===== built_to_suit
    public function built_to_suit(Request $request)
    {
        $built_to_suit = BuiltToSuit::wherenull('deleted_by')->first();
        // dd($built_to_suit);
        
        $projects = Project::with('category')
                    ->whereNull('deleted_by')
                    ->where('status', 1)
                    ->get();
                    
        return view('frontend.built_to_suit', compact('built_to_suit','projects'));
    }
    
    
    //===== built_to_suit Gallery
    public function built_project_gallery(Request $request)
    {
        $projects_banner = BuiltToSuitGallery::wherenull('deleted_by')->first();
        $projects = BuiltToSuitGallery::wherenull('deleted_by')->orderBy('priority', 'asc')->get();
        
        return view('frontend.built_project_gallery', compact('projects','projects_banner'));
    }
    
    //=========== projectsssssss
    public function project()
    {
        // Fetch all categories with their projects
        $categories = ProjectCategory::with(['projects' => function($query) {
            $query->whereNull('deleted_by'); // only active projects
        }])->whereNull('deleted_by')->get();
    
        return view('frontend.project', compact('categories'));
    }

    //=========== project_listing
    public function project_listing($slug)
    {
        // dd($slug);
        $category = ProjectCategory::where('slug', $slug)->firstOrFail();

        // Fetch projects belonging to that category
        $projects = Project::with('category')
            ->where('category_id', $category->id)
            ->whereNull('deleted_by')
            ->get();

        // dd($projects);

        return view('frontend.project_listing', compact('projects', 'category'));
    }

    //=========== project_details
    public function project_details($categorySlug, $projectSlug)
    {
        // Fetch category to verify URL
        $category = ProjectCategory::where('slug', $categorySlug)->firstOrFail();

        // Fetch project by slug and category
        $project = Project::where('slug', $projectSlug)
                        ->where('category_id', $category->id)
                        ->whereNull('deleted_by')
                        ->firstOrFail();

        // Fetch project details from projects_details table
        $projectDetails = ProjectsDetails::where('project_id', $project->id)
                            ->whereNull('deleted_by')
                            ->firstOrFail();
        // dd($projectDetails);

        return view('frontend.project_details', compact('project', 'category', 'projectDetails'));
    }

    //===== PRODUCT Finder Filetrs via different Pages
    // public function product_finder(Request $request)
    // {
    //     $categoryFilter = $request->get('category');
      
    //     $selectedLightAppId = $request->get('light_application'); 
    //     $selectedApplicationId = null; 
        
        
        
    //     // ===== Add filtered categories logic here =====
    //     $filteredCategories = collect();

    //     if ($selectedLightAppId) {
    //         // Get the selected light application
    //         $lightApp = LightApplications::where('slug', $selectedLightAppId)
    //             ->whereNull('deleted_by')
    //             ->first();
        
    //         if ($lightApp) {
    //             // Get sub_category IDs from LightApplications table (CSV)
    //             $subCategoryIds = explode(',', $lightApp->sub_category_id);
        
    //             // Fetch categories from Category table that match these IDs
    //             $filteredCategories = Category::whereIn('id', $subCategoryIds)
    //                 ->whereNull('deleted_by')
    //                 ->get();
    //         }
    //     }

        
    //     // dd($filteredCategories);


    //     $productsQuery = DB::table('products as p')
    //         ->join('category as c', 'p.category_id', '=', 'c.id')
    //         ->join('application_type as a', 'c.application_id', '=', 'a.id')
    //         ->join('sub_products as sp', function ($join) {
    //             $join->on('p.id', '=', 'sp.product_id')
    //                 ->whereNull('sp.deleted_by');
    //         })
    //         ->select(
    //             'p.id as product_id',
    //             'p.product',
    //             'p.thumbnail_image',
    //             'p.thumbnail_image1',
    //             'p.slug as product_slug',
    //             'a.slug as application_slug',
    //             'sp.id as sub_product_id',
    //             'sp.sub_product',
    //             'sp.slug as sub_product_slug',
    //             'sp.thumbnail_image as sub_thumbnail',
    //             'c.category',
    //             'c.slug as category_slug',
    //             'sp.category_id as sp_category_ids',
    //             'sp.light_application_type_id as sp_light_app_ids',
    //             'sp.application_id as sp_application_id'
    //         )
    //         ->whereNull('p.deleted_by');
            
    //         // dd($productsQuery->toSql(), $productsQuery->getBindings());

    //     // Filter by category if provided
    //     if ($categoryFilter) {
    //         $category = DB::table('category')
    //             ->where('slug', $categoryFilter)
    //             ->whereNull('deleted_by')
    //             ->first();
                
        

    //         if ($category) {
    //             $categoryId = $category->id;

    //             // Filter products by this category
    //             $productsQuery->whereRaw("FIND_IN_SET(?, sp.category_id)", [$categoryId]);

    //             // Directly get application_id from category table
    //             $applicationId = $category->application_id;

    //             if ($applicationId) {
    //                 $selectedApplicationId = $applicationId;
    //             }
    //         } else {
    //             $productsQuery->whereRaw("1=0"); // invalid slug
    //         }
    //     }

    //     // Filter by selected light application if provided
    //     if ($selectedLightAppId) {
    //         $lightApp = LightApplications::where('slug', $selectedLightAppId)
    //             ->whereNull('deleted_by')
    //             ->first();

    //         if ($lightApp) {
    //             $lightAppId = $lightApp->id;
    //             $productsQuery->whereRaw("FIND_IN_SET(?, sp.light_application_type_id)", [$lightAppId]);
    //         } else {
    //             $productsQuery->whereRaw("1=0");
    //         }
    //     }

    //     $products = $productsQuery->get()->groupBy('product');
    //     // dd($products);





    //     // Other data (same as before)
    //     $categories = DB::table('category as c')
    //         ->join('application_type as a', 'c.application_id', '=', 'a.id')
    //         ->select('c.*', 'a.application_type')
    //         ->whereNull('c.deleted_by')
    //         ->get();

    //     $banner = SubProduct::first();

    //     $applicationTypes = Applications::whereNull('deleted_by')
    //         ->whereNotIn('application_type', ['Built - To - Suit'])
    //         ->get();

    //     $category = Category::whereNull('deleted_by')->get();
    //     $lightapplicationTypes = LightApplications::whereNull('deleted_by')->get();

    //     $mounting_types = DB::table('model_details')->whereNotNull('mounting_type')->distinct()->pluck('mounting_type');
    //     $ip_ratings = DB::table('model_details')->whereNotNull('ip_rating')->distinct()->pluck('ip_rating');
    //     $orientations = DB::table('model_details')->whereNotNull('orientation')->distinct()->pluck('orientation');
    //     $optics = DB::table('model_details')->whereNotNull('optics')->distinct()->pluck('optics');

    //     return view('frontend.product_finder', compact(
    //         'categories', 'products', 'banner',
    //         'applicationTypes','category', 
    //         'mounting_types', 'ip_ratings', 
    //         'orientations', 'optics','lightapplicationTypes',
    //         'categoryFilter', 'selectedLightAppId', 
    //         'selectedApplicationId','filteredCategories' 
    //     ));
    // }
    
    
    public function product_finder(Request $request)
    {
        $metaTitle = '';
        $metaDescription = '';
        
        $cannonical = '';
        $hreflang = '';
        $og_tag = '';
        $twitter_card_tag = '';
        
        
        $metaTitle1 = '';
        $metaDescription1 = '';
        
        $cannonical1 = '';
        $hreflang1 = '';
        $og_tag1 = '';
        $twitter_card_tag1 = '';
        
        
        $categoryFilter = $request->get('category');
      
        $selectedLightAppId = $request->get('application'); 
        $selectedApplicationId = null; 
        
        
        
        // ===== Add filtered categories logic here =====
        $filteredCategories = collect();

        if ($selectedLightAppId) {
            // Get the selected light application
            $lightApp = LightApplications::where('slug', $selectedLightAppId)
                ->whereNull('deleted_by')
                ->first();
                
            // dd($lightApp);
        
            if ($lightApp) {
                // Get sub_category IDs from LightApplications table (CSV)
                $subCategoryIds = explode(',', $lightApp->sub_category_id);
        
                // Fetch categories from Category table that match these IDs
                $filteredCategories = Category::whereIn('id', $subCategoryIds)
                    ->whereNull('deleted_by')
                    ->get();
            }
        }

        
        // dd($filteredCategories);


        $productsQuery = DB::table('products as p')
            ->join('category as c', 'p.category_id', '=', 'c.id')
            ->join('application_type as a', 'c.application_id', '=', 'a.id')
            ->join('sub_products as sp', function ($join) {
                $join->on('p.id', '=', 'sp.product_id')
                    ->whereNull('sp.deleted_by');
            })
            ->select(
                'p.id as product_id',
                'p.product',
                'p.thumbnail_image',
                'p.thumbnail_image1',
                'p.slug as product_slug',
                'a.slug as application_slug',
                'sp.id as sub_product_id',
                'sp.sub_product',
                'sp.slug as sub_product_slug',
                'sp.thumbnail_image as sub_thumbnail',
                'c.category',
                'c.slug as category_slug',
                'sp.category_id as sp_category_ids',
                'sp.light_application_type_id as sp_light_app_ids',
                'sp.application_id as sp_application_id'
            )
            ->whereNull('p.deleted_by');
            
            // dd($productsQuery->toSql(), $productsQuery->getBindings());

        // Filter by category if provided
        if ($categoryFilter) {
            $category = DB::table('category')
                ->where('slug', $categoryFilter)
                ->whereNull('deleted_by')
                ->first();
                
        

            if ($category) {
                $categoryId = $category->id;

                // Filter products by this category
                $productsQuery->whereRaw("FIND_IN_SET(?, sp.category_id)", [$categoryId]);
                
                // ✅ Set category SEO (temporary)
                $metaTitle = $category->meta_title ?? $category->category;
                $metaDescription = $category->meta_description ?? '';
                
                $cannonical = $category->cannonical ?? $category->category;
                $hreflang = $category->hreflang ?? '';
                $og_tag = $category->og_tag ?? $category->category;
                $twitter_card_tag = $category->twitter_card_tag ?? '';
                

                // Directly get application_id from category table
                $applicationId = $category->application_id;

                if ($applicationId) {
                    $selectedApplicationId = $applicationId;
                }
            } else {
                $productsQuery->whereRaw("1=0"); // invalid slug
            }
        }

        // Filter by selected light application if provided
        if ($selectedLightAppId) {
            $lightApp = LightApplications::where('slug', $selectedLightAppId)
                ->whereNull('deleted_by')
                ->first();

            if ($lightApp) {
                
                // ✅ SET SEO FROM LIGHT APPLICATION
                $metaTitle1 = $lightApp->meta_title ?? $lightApp->light_application_type;
                $metaDescription1 = $lightApp->meta_description ?? '';
            
                $cannonical1 = $lightApp->cannonical ?? '';
                $hreflang1 = $lightApp->hreflang ?? '';
                $og_tag1 = $lightApp->og_tag ?? '';
                $twitter_card_tag1 = $lightApp->twitter_card_tag ?? '';
    
    
                $lightAppId = $lightApp->id;
                $productsQuery->whereRaw("FIND_IN_SET(?, sp.light_application_type_id)", [$lightAppId]);
            } else {
                $productsQuery->whereRaw("1=0");
            }
        }

        $products = $productsQuery->get()->groupBy('product');
        // dd($productsQuery);





        // Other data (same as before)
        $categories = DB::table('category as c')
            ->join('application_type as a', 'c.application_id', '=', 'a.id')
            ->select('c.*', 'a.application_type')
            ->whereNull('c.deleted_by')
            ->get();

        $banner = SubProduct::first();

        $applicationTypes = Applications::whereNull('deleted_by')
            ->whereNotIn('application_type', ['Built - To - Suit'])
            ->get();
        // dd($applicationTypes);

        $category = Category::whereNull('deleted_by')->get();
        $lightapplicationTypes = LightApplications::whereNull('deleted_by')->get();

        $mounting_types = DB::table('model_details')->whereNotNull('mounting_type')->distinct()->pluck('mounting_type');
        $ip_ratings = DB::table('model_details')->whereNotNull('ip_rating')->distinct()->pluck('ip_rating');
        $orientations = DB::table('model_details')->whereNotNull('orientation')->distinct()->pluck('orientation');
        $optics = DB::table('model_details')->whereNotNull('optics')->distinct()->pluck('optics');

        return view('frontend.product_finder', compact(
            'categories', 'products', 'banner',
            'applicationTypes','category', 
            'mounting_types', 'ip_ratings', 
            'orientations', 'optics','lightapplicationTypes',
            'categoryFilter', 'selectedLightAppId', 
            'selectedApplicationId','filteredCategories', 'metaTitle', 'metaDescription','cannonical','hreflang','og_tag','twitter_card_tag',
            'metaTitle1', 'metaDescription1','cannonical1','hreflang1','og_tag1','twitter_card_tag1'
            
        ));
    }
    

    //===== PRODUCT Finder Internal Filters
    public function filter(Request $request)
    {
        $query = SubProduct::query();

        if ($request->filled('main_category')) {
            $query->whereRaw('FIND_IN_SET(?, application_id)', [$request->main_category]);
        }

        if ($request->filled('sub_category')) {
            $query->whereRaw('FIND_IN_SET(?, category_id)', [$request->sub_category]);
        }

        if ($request->filled('application')) {
            $lightAppId = LightApplications::where('slug', $request->application)->value('id');
            if ($lightAppId) {
                $query->whereRaw('FIND_IN_SET(?, light_application_type_id)', [$lightAppId]);
            }
        }

        if ($request->filled('mounting_type') || $request->filled('ip_rating') || $request->filled('orientation') || $request->filled('optics')) {
            $query->whereHas('modelDetails', function($q) use ($request) {
                if ($request->filled('mounting_type')) {
                    $q->where('mounting_type', $request->mounting_type);
                }
                if ($request->filled('ip_rating')) {
                    $q->where('ip_rating', $request->ip_rating);
                }
                if ($request->filled('orientation')) {
                    $q->where('orientation', $request->orientation);
                }
                if ($request->filled('optics')) {
                    $q->where('optics', $request->optics);
                }
            });
        }


        $query->whereNull('deleted_by');

        $products = $query->get()
            ->filter(function($subProduct) {
                // Get first application slug from CSV
                $firstAppId = explode(',', $subProduct->application_id)[0] ?? null;
                $applicationSlug = $firstAppId ? Applications::where('id', $firstAppId)->value('slug') : null;

                // Attach these as properties for Blade
                $subProduct->application_slug = $applicationSlug;
                $subProduct->product_slug = $subProduct->slug;
                
                // ✅ ADD THIS (IMPORTANT FIX)
                $subProduct->category_slug = $subProduct->category_id 
                    ? Category::where('id', $subProduct->category_id)->value('slug') 
                    : null;
                
                // PRODUCT TABLE DATA
                if ($subProduct->product_id) {
                    $product = Product::find($subProduct->product_id);
                
                    if ($product) {
                        // ALWAYS override with real product images
                        $subProduct->thumbnail_image  = $product->thumbnail_image;   // new variable
                        $subProduct->thumbnail_image1 = $product->thumbnail_image1;  // new variable
                    }
                }

                // Fetch product name from Products table
                $subProduct->product_name = $subProduct->product_id 
                        ? Product::where('id', $subProduct->product_id)->value('product') 
                        : 'Unknown';
                        
                // Fetch category name
                $subProduct->category_name = $subProduct->category_id 
                        ? Category::where('id', $subProduct->category_id)->value('category') 
                        : 'Uncategorized';


                // Only include if both slugs exist
                return $applicationSlug && $subProduct->slug;
            })
            ->groupBy('product_name');
        
            // dd($products);
            
            
            


        $html = view('frontend.partials_product_list', compact('products'))->render();

        return response()->json(['html' => $html]);
    }
    
    
    

    //===== Contact Us
    public function contact_us()
    {
        $contact_us = Contact::whereNull('deleted_by')->first();
        return view('frontend.contact_us', compact('contact_us'));
    }

    //===== Privacy Policy
    public function terms_and_conditions()
    {
        $terms_and_conditions = TermsConditions::whereNull('deleted_by')->first();
        $terms_and_conditions_data = TermsConditions::whereNull('deleted_by')->get();
        return view('frontend.terms_and_conditions', compact('terms_and_conditions','terms_and_conditions_data'));
    }

    //===== Terms & Conditions
    public function privacy_policy()
    {
        $privacy_policy = PrivacyPolicy::whereNull('deleted_by')->first();
        $privacy_policy_data = PrivacyPolicy::whereNull('deleted_by')->get();
        return view('frontend.privacy_policy', compact('privacy_policy','privacy_policy_data'));
    }


    //===== Careers
    public function careers()
    {
        $careers = Career::whereNull('deleted_by')->first();
        $jobs = Jobs::whereNull('deleted_by')->get();
        return view('frontend.careers', compact('careers','jobs'));
    }
    
    //===== Articles
    public function articles()
    {
        $articles_banner = Blog::whereNull('deleted_by')->first();
        $articles = Blog::whereNull('deleted_by')->paginate(6);

        return view('frontend.articles', compact('articles_banner','articles'));
    }
    
    // ===== Article Details
    public function articles_details($slug)
    {
        // Fetch the article by slug from the Blog table
        $article = Blog::where('slug', $slug)
                    ->whereNull('deleted_by')
                    ->firstOrFail();
    
        // Optionally, you can also fetch related BlogDetails if needed
        $article_details = BlogDetails::where('blog_id', $article->id)
                        ->whereNull('deleted_by')
                        ->first();
        // dd($article_details);
    
        return view('frontend.articles_details', compact('article', 'article_details'));
    }

    //===== thank_you
    public function thank_you()
    {
        return view('frontend.thankyou');
    }
    
    
    //===== Resources
    public function resources(Request $request)
    {
        $catalog = Catalog::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        $individual_catalog = IndividualCatalog::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();
        $brochure = Brochure::orderBy('created_at', 'asc')->wherenull('deleted_by')->get();

        // $products = Product::pluck('thumbnail_image', 'product'); 
        
        $products = $individual_catalog->pluck('thumbnail_image', 'section_title')->toArray();
        
        return view('frontend.resource', compact('catalog','individual_catalog','brochure','products'));
    }


    //===== Resources Download
    public function brochure_download(Request $request)
    {
        $request->validate([
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email_id'       => 'required|email',
            'phone_number'   => 'required',
            'document_path'  => 'required',
            'document_title' => 'required', 
        ]);
    
        $data = [
            'first_name'     => $request->first_name,
            'last_name'      => $request->last_name,
            'email_id'       => $request->email_id,
            'phone_number'   => $request->phone_number,
            'document_type'  => $request->document_type,
            'document_title' => $request->document_title, 
        ];
    
        // Send Email
        Mail::send('frontend.brochure_mail', $data, function ($message) use ($data) {
            $message->to('info@lazurelighting.com')
                    ->subject('New Recourses Inquiry - ' . $data['document_type'] . ' - ' . $data['document_title']);
        });
    
        // Redirect to Resources Page with download parameter
        return redirect()->route('site.resources', [
            'download' => $request->document_path
        ]);
    }



    //===== Contact Form Mail Send
    public function send_contact_mail(Request $request)
    {

        Log::info('Contact form submission started', [
            'time' => now(),
            'ip' => $request->ip(),
            'email' => $request->email,
        ]);

        $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'phone' => 'required|digits_between:10,15',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'g-recaptcha-response' => 'required',
        ]);
        

        $secret = env('RECAPTCHA_SECRET_KEY');
    
        $captchaVerify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
    
        $captchaResult = $captchaVerify->json();
    
        if (!isset($captchaResult['success']) || $captchaResult['success'] !== true) {
            return back()
                ->withErrors(['captcha' => 'reCAPTCHA verification failed.'])
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'user_message' => $request->message,
        ];
        
        Log::info('Preparing admin email', [
            'to' => 'info@lazurelighting.com',
            'subject' => 'New Contact Form Enquiry',
        ]);


        // Send mail to Admin
        Mail::send('frontend.contact_admin', $data, function($message) use($data) {
            $message->to('info@lazurelighting.com')
                    //  ->cc(['riddhi@matrixbricks.com','shweta@matrixbricks.com'])
                    ->subject('New Contact Form Enquiry');
        });



        Log::info('Admin email sent successfully');

        Log::info('Preparing user thank you email', [
            'to' => $data['email'],
            'subject' => 'Thank You for Reaching out!',
        ]);

        // Send mail to User
        Mail::send('frontend.contact_user_mail', $data, function($message) use($data) {
            $message->to($data['email'])
                    ->subject('Thank You for Reaching out!');
        });


        Log::info('User thank you email sent successfully');

        Log::info('Contact form process completed successfully');
        
        return redirect()->route('thank.you');
    }
    

    //===== Product Enquiry Form Mail Send
    public function send_product_enquiry(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email_id'      => 'required|email',
            'phone_number' => 'required|numeric|digits_between:10,15',
            'intro'         => 'nullable|string|max:1000',
            'product_name'  => 'required|string',
            'sub_product_name' => 'required|string',
            'g-recaptcha-response' => 'required',
        ]);
    
    
        $secret = env('RECAPTCHA_SECRET_KEY');
    
        $captchaVerify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
    
        $captchaResult = $captchaVerify->json();
    
        if (!isset($captchaResult['success']) || $captchaResult['success'] !== true) {
            return back()
                ->withErrors(['captcha' => 'reCAPTCHA verification failed.'])
                ->withInput();
        }


        $mailData = [
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email_id'         => $request->email_id,
            'phone_number'     => $request->phone_number,
            'intro'            => $request->intro,
            'product_name'     => $request->product_name,
            'sub_product_name' => $request->sub_product_name,
        ];
    
        // 📩 Send Email to Admin
        Mail::send('frontend.product_inquiry_admin_mail', $mailData, function ($message) use ($mailData) {
            $subject = "New Product Inquiry - " . $mailData['sub_product_name'];
        
            $message->to('info@lazurelighting.com')
                    //  ->cc(['riddhi@matrixbricks.com','shweta@matrixbricks.com'])
                    ->subject($subject)
                    ->replyTo($mailData['email_id']);
        });
    
    
        // 📩 Send Confirmation Email to User
        Mail::send('frontend.product_user_inquiry_mail', $mailData, function ($message) use ($mailData) {
            $message->to($mailData['email_id'])
                    ->subject("Thank you for Reaching Out!");
        });
    
        return redirect()->route('thank.you');

    }


    //===== Career Form Mail Send
    public function career_mail(Request $request)
    {
        $request->validate([
            'positionApplied' => 'required',
            'fullName'        => 'required|string|max:100',
            'email'           => 'required|email',
            'phone'           => 'required|digits_between:10,15',
            'resume'          => 'required|mimes:pdf,doc,docx|max:5120', // 5MB max
            'agree'           => 'accepted',
            'g-recaptcha-response' => 'required',
        ]);
    
    
        $secret = env('RECAPTCHA_SECRET_KEY');
    
        $captchaVerify = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);
    
        $captchaResult = $captchaVerify->json();
    
        if (!isset($captchaResult['success']) || $captchaResult['success'] !== true) {
            return back()
                ->withErrors(['captcha' => 'reCAPTCHA verification failed.'])
                ->withInput();
        }
        
        $resumeFile = $request->file('resume');
        $resumePath = $resumeFile->getRealPath();
        $resumeName = $resumeFile->getClientOriginalName();
    
        $mailData = [
            'positionApplied' => $request->positionApplied,
            'fullName' => $request->fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'userMessage' => $request->message ?? 'N/A',
        ];
    
        // 📩 Send mail to admin with attachment
        Mail::send('frontend.career_admin_mail', $mailData, function ($message) use ($mailData, $resumePath, $resumeName) {
            $message->to('info@lazurelighting.com')
                    // ->cc(['riddhi@matrixbricks.com','shweta@matrixbricks.com'])
                    ->subject("New Job Application - " . $mailData['positionApplied'])
                    ->attach($resumePath, [
                        'as' => $resumeName,
                        'mime' => mime_content_type($resumePath)
                    ]);
        });
    
        // 📬 Auto-reply to user
        Mail::send('frontend.career_user_mail', $mailData, function ($message) use ($mailData) {
            $message->to($mailData['email'])
                    ->subject("We Received Your Application - " . $mailData['positionApplied']);
        });
    
        return redirect()->route('thank.you');
    }



}