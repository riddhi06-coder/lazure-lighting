<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/4.3.0/apexcharts.min.js"></script>
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->


        @php 
            $application_type = DB::table('application_type')
                                ->whereNull('deleted_by')
                                ->count();
            
            $category = DB::table('category')
                                ->whereNull('deleted_by')
                                ->count();
                                
            $products = DB::table('products')
                                ->whereNull('deleted_by')
                                ->count();
                                
            $sub_products = DB::table('sub_products')
                                ->whereNull('deleted_by')
                                ->count();
                                
            $projects_category = DB::table('project_category')
                                ->whereNull('deleted_by')
                                ->count();
                                
            $projects = DB::table('projects')
                                ->whereNull('deleted_by')
                                ->count();
                                
                                
            $blogs = DB::table('blogs')
                                ->whereNull('deleted_by')
                                ->count();
                                
                                
            $jobs = DB::table('job_list')
                                ->whereNull('deleted_by')
                                ->count();
            
            
        @endphp
        
       <div class="page-body"> 
          <div class="container-fluid">            
            <div class="page-title"> 
              <div class="row">
                
                
              </div>
            </div>
          </div>


        <!-- Container-fluid starts -->
          <div class="container-fluid">
            <div class="row"> 
                
                <div class="col-xl-3 col-sm-6">
                  
                    <div class="card o-hidden small-widget">
                      <div class="card-body total-project border-b-primary border-2"><span class="f-light f-w-500 f-14">Total Product Catgeory</span>
                        <div class="project-details"> 
                          <div class="project-counter"> 
                            <h2 class="f-w-600">{{ $application_type }}</h2><span class="f-12 f-w-400">(This month)</span>
                          </div>
                          <div class="product-sub bg-primary-light">
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#color-swatch') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles">
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                        </ul>
                      </div>
                    </div>
                    
                </div>

                <div class="col-xl-3 col-sm-6">
                <div class="card o-hidden small-widget">
                  <div class="card-body total-Progress border-b-warning border-2"> <span class="f-light f-w-500 f-14">Total Product Sub Catgeories</span>
                    <div class="project-details">
                      <div class="project-counter">
                        <h2 class="f-w-600">{{ $category}}</h2><span class="f-12 f-w-400">(This month) </span>
                      </div>
                      <div class="product-sub bg-warning-light"> 
                        <svg class="invoice-icon">
                          <use href="{{ asset('admin/assets/svg/icon-sprite.svg#tick-circle') }}"></use>
                        </svg>
                      </div>
                    </div>
                    <ul class="bubbles">
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                      <li class="bubble"></li>
                    </ul>
                  </div>
                </div>
              </div>
                  
                <div class="col-xl-3 col-sm-6">
                    <div class="card o-hidden small-widget">
                      <div class="card-body total-Complete border-b-secondary border-2"><span class="f-light f-w-500 f-14">Total Products</span>
                        <div class="project-details">
                          <div class="project-counter">
                            <h2 class="f-w-600">{{ $products}}</h2><span class="f-12 f-w-400">(This month) </span>
                          </div>
                          <div class="product-sub bg-secondary-light"> 
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#add-square') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles"> 
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  
                <div class="col-xl-3 col-sm-6">
                  
                <div class="card o-hidden small-widget">
                      <div class="card-body total-project border-b-primary border-2"><span class="f-light f-w-500 f-14">Total Sub Product</span>
                        <div class="project-details"> 
                          <div class="project-counter"> 
                            <h2 class="f-w-600">{{ $sub_products }}</h2><span class="f-12 f-w-400">(This month)</span>
                          </div>
                          <div class="product-sub bg-primary-light">
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#color-swatch') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles">
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                        </ul>
                      </div>
                    </div>
                </div>
             
                <div class="col-xl-3 col-sm-6">
                    <div class="card o-hidden small-widget">
                      <div class="card-body total-Progress border-b-warning border-2"> <span class="f-light f-w-500 f-14">Total Project Catgeories</span>
                        <div class="project-details">
                          <div class="project-counter">
                            <h2 class="f-w-600">{{ $projects_category }}</h2><span class="f-12 f-w-400">(This month) </span>
                          </div>
                          <div class="product-sub bg-warning-light"> 
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#tick-circle') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles">
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  
                <div class="col-xl-3 col-sm-6">
                    <div class="card o-hidden small-widget">
                      <div class="card-body total-Complete border-b-secondary border-2"><span class="f-light f-w-500 f-14">Total Projects</span>
                        <div class="project-details">
                          <div class="project-counter">
                            <h2 class="f-w-600">{{ $projects }}</h2><span class="f-12 f-w-400">(This month) </span>
                          </div>
                          <div class="product-sub bg-secondary-light"> 
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#add-square') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles"> 
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  
                <div class="col-xl-3 col-sm-6">
                  
                <div class="card o-hidden small-widget">
                      <div class="card-body total-project border-b-primary border-2"><span class="f-light f-w-500 f-14">Total Blogs</span>
                        <div class="project-details"> 
                          <div class="project-counter"> 
                            <h2 class="f-w-600">{{ $blogs }}</h2><span class="f-12 f-w-400">(This month)</span>
                          </div>
                          <div class="product-sub bg-primary-light">
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#color-swatch') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles">
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                        </ul>
                      </div>
                    </div>
                
                </div>
                  
                <div class="col-xl-3 col-sm-6">
                    <div class="card o-hidden small-widget">
                      <div class="card-body total-Complete border-b-secondary border-2"><span class="f-light f-w-500 f-14">Total Jobs</span>
                        <div class="project-details">
                          <div class="project-counter">
                            <h2 class="f-w-600">{{ $jobs }}</h2><span class="f-12 f-w-400">(This month) </span>
                          </div>
                          <div class="product-sub bg-secondary-light"> 
                            <svg class="invoice-icon">
                              <use href="{{ asset('admin/assets/svg/icon-sprite.svg#add-square') }}"></use>
                            </svg>
                          </div>
                        </div>
                        <ul class="bubbles"> 
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                          <li class="bubble"></li>
                          <li class="bubble"></li>
                          <li class="bubble"> </li>
                        </ul>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <!-- Container-fluid Ends -->
        </div>
        <!-- footer start-->
        @include('components.backend.footer')
      </div>
    </div>

        
    
    @include('components.backend.main-js')










        
</body>

</html>