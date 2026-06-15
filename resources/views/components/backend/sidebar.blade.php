<!-- Page Body Start-->
 <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg" style="width:18%;">
          <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.png') }}" alt="" style="max-width: 80% !important;"></a>
		  	<a href="{{ route('admin.dashboard') }}">
				<!-- <img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo-icon.png') }}" alt="" style="max-width: 65% !important;"> -->
			</a>  
		  <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
          </div>
          <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/favicon-1.png') }}" alt=""  style="max-width: 20% !important; margin-right:30px; margin-left:0px;"></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo//images/favicon-1.png') }}" alt="" style="max-width: 40% !important; margin-right:65px;"></a>
                  <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>

                <li class="sidebar-list {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                    </svg>
                    <span class="lan-3">Dashboard</span>
                  </a>
                </li>


                <li class="sidebar-list {{ request()->routeIs('manage-application.index', 'manage-category.index', 'manage-product.index', 'manage-sub-product.index', 'manage-light-application.index', 'manage-detailed-page.index', 'manage-model-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <span>Products</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-application.index') }}" class="{{ request()->routeIs('manage-application.index') ? 'active' : '' }}">Main Category</a></li>
                    <li><a href="{{ route('manage-category.index') }}" class="{{ request()->routeIs('manage-category.index') ? 'active' : '' }}">Sub Category</a></li>
                    <li><a href="{{ route('manage-light-application.index') }}" class="{{ request()->routeIs('manage-light-application.index') ? 'active' : '' }}">Light Applications</a></li>
                    <li><a href="{{ route('manage-product.index') }}" class="{{ request()->routeIs('manage-product.index') ? 'active' : '' }}">Products List</a></li>
                    <li><a href="{{ route('manage-sub-product.index') }}" class="{{ request()->routeIs('manage-sub-product.index') ? 'active' : '' }}">Sub Products List</a></li>
                    <li><a href="{{ route('manage-detailed-page.index') }}" class="{{ request()->routeIs('manage-detailed-page.index') ? 'active' : '' }}">SubProducts Details</a></li>
                    <li><a href="{{ route('manage-model-details.index') }}" class="{{ request()->routeIs('manage-model-details.index') ? 'active' : '' }}">Model Details</a></li>
                  </ul>
                </li>

                
                <li class="sidebar-list {{ request()->routeIs('manage-banner.index', 'manage-navigations.index', 'manage-featured-products.index', 'manage-app-intro.index', 'manage-app-intro.index','manage-clientele.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-icons') }}"></use>
                    </svg>
                    <span>Home page</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-banner.index') }}" class="{{ request()->routeIs('manage-banner.index') ? 'active' : '' }}">Banner Details</a></li>
                    <li><a href="{{ route('manage-navigations.index') }}" class="{{ request()->routeIs('manage-navigations.index') ? 'active' : '' }}">Navigations</a></li>
                    <li><a href="{{ route('manage-clientele.index') }}" class="{{ request()->routeIs('manage-clientele.index') ? 'active' : '' }}">Our Clientele</a></li>
                    <li><a href="{{ route('manage-featured-products.index') }}" class="{{ request()->routeIs('manage-featured-products.index') ? 'active' : '' }}">Featured Products</a></li>
                    <li><a href="{{ route('manage-advertise.index') }}" class="{{ request()->routeIs('manage-advertise.index') ? 'active' : '' }}">Advertisement</a></li>
                    <li><a href="{{ route('manage-app-intro.index') }}" class="{{ request()->routeIs('manage-app-intro.index') ? 'active' : '' }}">Application Intro</a></li>
                    
                  </ul>
                </li>
                
                <li class="sidebar-list {{ request()->routeIs('manage-built-to-suit.index','manage-gallery-built.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-board') }}"></use>
                    </svg>
                    <span>Built To Suit</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-built-to-suit.index') }}" class="{{ request()->routeIs('manage-built-to-suit.index') ? 'active' : '' }}">Page Details</a></li>
                    <li><a href="{{ route('manage-gallery-built.index') }}" class="{{ request()->routeIs('manage-gallery-built.index') ? 'active' : '' }}">Project Gallery</a></li>
                   
                  </ul>
                </li>
                
                
                <li class="sidebar-list {{ request()->routeIs('manage-about-us.index', 'manage-our-journey.index', 'manage-expertise.index', 'manage-sub-product.index', 'product-sizes.index', 'product-prints.index', 'product-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#return-box') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#return-box') }}"></use>
                    </svg>
                    <span>About Us</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-about-us.index') }}" class="{{ request()->routeIs('manage-about-us.index') ? 'active' : '' }}">About Lazure</a></li>
                    <li><a href="{{ route('manage-our-journey.index') }}" class="{{ request()->routeIs('manage-our-journey.index') ? 'active' : '' }}">Our Journey</a></li>
                    <li><a href="{{ route('manage-expertise.index') }}" class="{{ request()->routeIs('manage-expertise.index') ? 'active' : '' }}">Engineering Expertise</a></li>
                  </ul>
                </li>



                <li class="sidebar-list {{ request()->routeIs('manage-project-category.index', 'manage-projects.index','manage-projects-details') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#product-detail') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#product-detail') }}"></use>
                    </svg>
                    <span>Projects</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-project-category.index') }}" class="{{ request()->routeIs('manage-project-category.index') ? 'active' : '' }}">Project Category</a></li>
                    <li><a href="{{ route('manage-projects.index') }}" class="{{ request()->routeIs('manage-projects.index') ? 'active' : '' }}">Projects</a></li>
                    <li><a href="{{ route('manage-projects-details.index') }}" class="{{ request()->routeIs('manage-projects-details.index') ? 'active' : '' }}">Project Details</a></li>
                  </ul>
                </li>


                <li class="sidebar-list {{ request()->routeIs('manage-apps.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('manage-apps.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                    </svg>
                    <span>Design Intent</span>
                  </a>
                </li>
                
                
                
                <li class="sidebar-list {{ request()->routeIs('manage-full-catalog.index','manage-individual-series-catalog.index','manage-brochure.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                    </svg>
                    <span>Resources</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-full-catalog.index') }}" class="{{ request()->routeIs('manage-full-catalog.index') ? 'active' : '' }}">Full Catalog</a></li>
                    <li><a href="{{ route('manage-individual-series-catalog.index') }}" class="{{ request()->routeIs('manage-individual-series-catalog.index') ? 'active' : '' }}">Individual Series Catalog</a></li>
                   <li><a href="{{ route('manage-brochure.index') }}" class="{{ request()->routeIs('manage-brochure.index') ? 'active' : '' }}">Brochure</a></li>
                  
                  </ul>
                </li>
                
                
                <li class="sidebar-list {{ request()->routeIs('manage-career.index', 'manage-jobs.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                    </svg>
                    <span>Careers</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-career.index') }}" class="{{ request()->routeIs('manage-career.index') ? 'active' : '' }}">Page Details</a></li>
                    <li><a href="{{ route('manage-jobs.index') }}" class="{{ request()->routeIs('manage-jobs.index') ? 'active' : '' }}">Job Listing</a></li>
                  
                  </ul>
                </li>


                <li class="sidebar-list {{ request()->routeIs('manage-blogs.index', 'manage-blog-details.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-blog') }}"></use>
                    </svg>
                    <span>Blogs</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-blogs.index') }}" class="{{ request()->routeIs('manage-blogs.index') ? 'active' : '' }}">Add Blogs</a></li>
                    <li><a href="{{ route('manage-blog-details.index') }}" class="{{ request()->routeIs('manage-blog-details.index') ? 'active' : '' }}">Blog  Details</a></li>
                  </ul>
                </li>
                

                <li class="sidebar-list {{ request()->routeIs('manage-contact.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('manage-contact.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <span>Contact Details</span>
                  </a>
                </li>
                
                <li class="sidebar-list {{ request()->routeIs('manage-terms-conditions.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('manage-terms-conditions.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                    </svg>
                    <span>Terms & Conditions</span>
                  </a>
                </li>
                
                <li class="sidebar-list {{ request()->routeIs('manage-privacy-policy.index') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"></i>
                  <a class="sidebar-link" href="{{ route('manage-privacy-policy.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#income') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#income') }}"></use>
                    </svg>
                    <span>Privacy Policy</span>
                  </a>
                </li>
                
                

              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>


        