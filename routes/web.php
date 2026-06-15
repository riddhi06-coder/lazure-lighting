<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use App\Models\ProductDetails;
use Illuminate\Http\Request;

use App\Http\Controllers\Backend\UserDetailsController;
use App\Http\Controllers\Backend\UserPermissionsController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\FeaturedProductsController;
use App\Http\Controllers\Backend\AdvertiseController;
use App\Http\Controllers\Backend\HomeCategoriesController;
use App\Http\Controllers\Backend\ApplicationController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubProductController;
use App\Http\Controllers\Backend\AppIntroController;
use App\Http\Controllers\Backend\ProjectController;
use App\Http\Controllers\Backend\BlogsController;
use App\Http\Controllers\Backend\LightApplicationController;
use App\Http\Controllers\Backend\SubProducDetailsController;
use App\Http\Controllers\Backend\ModelDetailsController;
use App\Http\Controllers\Backend\AboutUsController;
use App\Http\Controllers\Backend\JourneyController;
use App\Http\Controllers\Backend\ExpertiseController;
use App\Http\Controllers\Backend\ProductApplicationController;
use App\Http\Controllers\Backend\BuiltToSuitController;
use App\Http\Controllers\Backend\ProjectsController;
use App\Http\Controllers\Backend\ProjectsDetailsController;
use App\Http\Controllers\Backend\ClienteleController;
use App\Http\Controllers\Backend\TermsConditionController;
use App\Http\Controllers\Backend\PrivacyPolicyController;
use App\Http\Controllers\Backend\CareerController;
use App\Http\Controllers\Backend\JobsController;
use App\Http\Controllers\Backend\BlogDetailsController;
use App\Http\Controllers\Backend\BuiltToSuitGalleryController;
use App\Http\Controllers\Backend\CatalogController;
use App\Http\Controllers\Backend\IndividualSeriesController;
use App\Http\Controllers\Backend\BrochureController;
use App\Http\Controllers\Backend\HomeNavigationsController;


use App\Http\Controllers\Frontend\HomeController;

// =========================================================================== Backend Routes

// Route::get('/', function () {
//     return view('frontend.index');
// });
  

// Authentication Routes
Route::get('/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get('/change-password', [LoginController::class, 'change_password'])->name('admin.changepassword');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('admin.updatepassword');

Route::get('/register', [LoginController::class, 'register'])->name('admin.register');
Route::post('/register', [LoginController::class, 'authenticate_register'])->name('admin.register.authenticate');
    
// Admin Routes with Middleware
Route::group(['middleware' => ['auth:web', \App\Http\Middleware\PreventBackHistoryMiddleware::class]], function () {
        Route::get('/dashboard', function () {
            return view('backend.dashboard'); 
        })->name('admin.dashboard');
});


// ==== Manage application Details
Route::resource('manage-application', ApplicationController::class);

// ==== Manage category
Route::resource('manage-category', CategoryController::class);

// ==== Manage Light Application
Route::resource('manage-light-application', LightApplicationController::class);

// ==== Manage product
Route::resource('manage-product', ProductController::class);
// Route::get('/get-categories/{applicationId}', [ProductController::class, 'getCategoriesByApplication'])->name('get.categories');

Route::post('/get-categories', [ProductController::class, 'getCategoriesByApplication']);

// ==== Manage sub product
Route::resource('manage-sub-product', SubProductController::class);
Route::get('/get-product-details/{productId}', [SubProductController::class, 'getProductDetails']);
Route::post('/manage-sub-product/update-priority/{id}', [SubProductController::class, 'updatePriority'])->name('manage-sub-product.update-priority');


// ==== Manage Sub Product Detailed Page
Route::resource('manage-detailed-page', SubProducDetailsController::class);

// ==== Manage Home Application Intro
Route::resource('manage-app-intro', AppIntroController::class);

// ==== Manage Home Navigations
Route::resource('manage-navigations', HomeNavigationsController::class);


// ==== Manage Add Proejcts Category
Route::resource('manage-project-category', ProjectController::class);

// ==== Manage Proejcts
Route::resource('manage-projects', ProjectsController::class);
Route::post('/manage-projects/status/{id}', [ProjectsController::class, 'updateStatus'])->name('manage-projects.status');

// ==== Manage Proejcts Details
Route::resource('manage-projects-details', ProjectsDetailsController::class);

// ==== Manage Banner Details
Route::resource('manage-banner', BannerController::class);
Route::patch('/manage-banner/priority/{id}', [BannerController::class, 'updatePriority'])->name('manage-banner.priority.update');


// ==== Manage Our Clientele
Route::resource('manage-clientele', ClienteleController::class);

// ==== Manage Featured Products
Route::resource('manage-featured-products', FeaturedProductsController::class);

// ==== Manage Advertise
Route::resource('manage-advertise', AdvertiseController::class);

// ==== Manage Advertise
Route::resource('manage-home-categories', HomeCategoriesController::class);

// ==== Manage Blogs
Route::resource('manage-blogs', BlogsController::class);
Route::post('/manage-blogs/status/{id}', [BlogsController::class, 'updateStatus'])->name('manage-blogs.status');

// ==== Manage Contact Details
Route::resource('manage-contact', ContactController::class);

// ==== Manage Model Details
Route::resource('manage-model-details', ModelDetailsController::class);
Route::post('/upload/spec-sheet', [ModelDetailsController::class, 'uploadSpecSheet'])->name('upload.spec_sheet');
Route::post('/upload/installation-manual', [ModelDetailsController::class, 'uploadInstallationManual'])->name('upload.installation_manual');
Route::post('/upload/drawings-2d', [ModelDetailsController::class, 'uploadDrawings2D'])->name('upload.drawings_2d');
Route::post('/upload/drawings-3d', [ModelDetailsController::class, 'uploadDrawings3D'])->name('upload.drawings_3d');

// ==== Manage About Us
Route::resource('manage-about-us', AboutUsController::class);

// ==== Manage Our Journey
Route::resource('manage-our-journey', JourneyController::class);

// ==== Manage Engineering Expertise
Route::resource('manage-expertise', ExpertiseController::class);

// ==== Manage Product Applications
Route::resource('manage-apps', ProductApplicationController::class);

// ==== Manage Built to Suit
Route::resource('manage-built-to-suit', BuiltToSuitController::class);

// ==== Manage Built to Suit Gallery
Route::resource('manage-gallery-built', BuiltToSuitGalleryController::class);
Route::post('/manage-gallery-built/update-priority/{id}', [BuiltToSuitGalleryController::class, 'updatePriority'])->name('manage-gallery-built.update-priority');

// ==== Manage Terms & Conditions
Route::resource('manage-terms-conditions', TermsConditionController::class);

// ==== Manage Privacy Policy
Route::resource('manage-privacy-policy', PrivacyPolicyController::class);

// ==== Manage Careers
Route::resource('manage-career', CareerController::class);

// ==== Manage Jobs
Route::resource('manage-jobs', JobsController::class);

// ==== Manage Blog Details
Route::resource('manage-blog-details', BlogDetailsController::class);

// ==== Manage Full Catalog
Route::resource('manage-full-catalog', CatalogController::class);

// ==== Manage Individual Series Catalog
Route::resource('manage-individual-series-catalog', IndividualSeriesController::class);

// ==== Manage Brochure
Route::resource('manage-brochure', BrochureController::class);




// // =========================================================================== Frontend Routes

Route::group(['prefix'=> '', 'middleware'=>[\App\Http\Middleware\PreventBackHistoryMiddleware::class]],function(){

    // ==== Home
    Route::get('/', [HomeController::class, 'home'])->name('frontend.index');
    Route::get('/lighting-products', [HomeController::class, 'product_list'])->name('products.index');
    Route::get('/lighting-applications/{application_type}', [HomeController::class, 'application_list'])->name('applications.list');
    Route::get('/category/{slug}', [HomeController::class, 'category_list'])->name('category.show');
    Route::get('/design-intent/{slug}', [HomeController::class, 'product_applications_details'])->name('applications.details');
    Route::get('/lighting-projects', [HomeController::class, 'project'])->name('projects');
    Route::get('/lighting-projects/{slug}', [HomeController::class, 'project_listing'])->name('projects.project_listing');
    Route::get('/lighting-projects/{category}/{slug}', [HomeController::class, 'project_details'])->name('projects.details');
    Route::get('/{application_slug}/{category_slug}/{product_slug}', [HomeController::class, 'subProductDetail'])->name('subproduct.detail');

    Route::get('/lighting-product-finder', [HomeController::class, 'product_finder'])->name('product.finder');
    Route::get('/about-lazure-lighting', [HomeController::class, 'about_lazure'])->name('about.lazure_lighting');
    Route::get('/our-journey', [HomeController::class, 'our_journey'])->name('our.journey');
    Route::get('/lighting-engineering-expertise', [HomeController::class, 'engineering_expertise'])->name('engineering.expertise');
    Route::get('/design-intent', [HomeController::class, 'product_applications'])->name('product.applications');
    Route::get('/design-intent/{slug}', [HomeController::class, 'product_applications_details'])->name('applications.details');
    Route::get('/filter-model-details', [HomeController::class, 'filterModelDetails'])->name('filter.model.details');
    Route::get('/lighting-applications', [HomeController::class, 'light_applications_listing'])->name('light_applications_listing');
    Route::get('/custom-lighting-solutions', [HomeController::class, 'built_to_suit'])->name('built_to_suit');
    Route::get('/lighting-project-gallery', [HomeController::class, 'built_project_gallery'])->name('built_project_gallery');
    Route::post('/products/filter', [HomeController::class, 'filter'])->name('products.filter');
    Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('frontend.contact_us');
    Route::get('/terms-and-conditions', [HomeController::class, 'terms_and_conditions'])->name('frontend.terms_and_conditions');
    Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('frontend.privacy_policy');
    Route::get('/careers-at-lazure', [HomeController::class, 'careers'])->name('frontend.careers');
    Route::get('/articles', [HomeController::class, 'articles'])->name('frontend.articles');
    
    Route::get('/thank-you', [HomeController::class, 'thank_you'])->name('thank.you');
    Route::post('/contact-submit', [HomeController::class, 'send_contact_mail'])->name('contact.send');
    Route::post('/product-inquiry', [HomeController::class, 'send_product_enquiry'])->name('send.product.inquiry');
    Route::post('/apply-job', [HomeController::class, 'career_mail'])->name('apply.job');
    Route::get('/resources', [HomeController::class, 'resources'])->name('site.resources');
    Route::post('/brochure-download', [HomeController::class, 'brochure_download'])->name('brochure.download');

    Route::get('/{slug}', [HomeController::class, 'articles_details'])->name('frontend.articles_details');

});


