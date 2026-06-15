@php
    $applicationTypes = \DB::table('application_type as at')
        ->join('category as c', 'at.id', '=', 'c.application_id')
        ->select('at.id', 'at.application_type', 'at.slug as application_slug', 'c.category','c.slug')
        ->orderBy('at.id')
        ->wherenull('c.deleted_by')
        ->get()
        ->groupBy('id'); // group by application type id


      // Fetch all project names
      $projects = \DB::table('project_category')
        ->select('category_name','slug') // change column name if needed
        ->orderBy('category_name', 'asc')
        ->wherenull('project_category.deleted_by')
        ->get();

@endphp
 
 <header>
      <section class="main_menu">
        <div class="container">
          <div class="row v-center">
            <div class="header-item item-left">
              <div class="logo">
                <a href="{{ route('frontend.index') }}"><img src="{{ asset('frontend/assets/images/home/logo.webp') }}" alt="Logo" width="180" height="28"></a>
              </div>
            </div>
            <!-- menu start here -->
            <div class="header-item item-center">
              <div class="menu-overlay"></div>
              <nav class="menu">
                <div class="mobile-menu-head">
                  <div class="go-back"><i class="fa fa-angle-left"></i></div>
                  <div class="current-menu-title"></div>
                  <div class="mobile-menu-close">×</div>
                </div>


                <ul class="menu-main">
                  <!--<li><a href="{{ route('frontend.index') }}">Home</a></li>-->


                  <li class="menu-item-has-children products-menu-wrap">
                    <a href="{{ route('products.index') }}" class="main-nav-link">Products 
                    <!--<i class="fa fa-angle-down"></i>-->
                    </a>
                     <span class="submenu-toggle">
                        <i class="fa fa-angle-down"></i>
                    </span>
                    <div class="sub-menu single-column-menu two-column-menu products-sub-menu-wrap">
                      <div class="row">
                        <div class="col-md-12">

                          <div class="row">
                              @foreach($applicationTypes as $appId => $categories)
                                  <div class="col-md-6 col-sm-12 list-item border-right-one">
                                      <h3>
                                        <a href="{{ route('applications.list', ['application_type' => $categories->first()->application_slug]) }}">
                                            {{ $categories->first()->application_type }}
                                        </a>
                                      </h3>

                                       <ul>
                                            @foreach($categories as $cat)
                                                <li>
                                                    <a href="{{ route('product.finder', ['category' => $cat->slug]) }}">
                                                        @if(stripos($cat->category, 'downlights') !== false || stripos($cat->category, 'wall') !== false)
                                                            {{ $cat->category }}
                                                        @else
                                                            {{ trim(str_ireplace('lights', '', $cat->category)) }}
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                  </div>
                              @endforeach
                          </div>

                        </div>
                      </div>
                    </div>
                  </li>


                  <li class="menu-item-has-children products-menu-wrap">
                      <a href="{{ route('projects') }}" class="main-nav-link">Projects 
                      <!--<i class="fa fa-angle-down"></i>-->
                      </a>
                      <span class="submenu-toggle">
                        <i class="fa fa-angle-down"></i>
                    </span>
                      <div class="sub-menu single-column-menu">
                          <ul>
                              @foreach($projects as $project)
                                  <li><a href="{{ route('projects.project_listing', $project->slug) }}">{{ $project->category_name }}</a></li>
                              @endforeach
                          </ul>
                      </div>
                  </li>


                  <!--<li><a href="{{ route('built_to_suit') }}">Built-to-suit</a></li>-->
                  
                   <li class="menu-item-has-children products-menu-wrap" >
                    <a href="#" class="main-nav-link">Built-to-suit
                    <!--<i class="fa fa-angle-down"></i>-->
                    </a>
                    <span class="submenu-toggle">
                        <i class="fa fa-angle-down"></i>
                    </span>
                    <div class="sub-menu single-column-menu">
                      <ul>
                        <li><a href="{{ route('built_to_suit') }}">Info</a></li>
                        <li><a href="{{ route('built_project_gallery') }}">Gallery</a></li>
                      </ul>
                    </div>
                  </li>


                  <li class="menu-item-has-children">
                    <a href="#">About Us <i class="fa fa-angle-down"></i></a>
                    <div class="sub-menu single-column-menu">
                      <ul>
                        <li><a href="{{ route('about.lazure_lighting') }}">About Lazure Lighting</a></li>
                        <li><a href="{{ route('our.journey') }}">Our Journey</a></li>
                        <li><a href="{{ route('engineering.expertise') }}">Engineering Expertise</a></li>
                      </ul>
                    </div>
                  </li>

                  <li><a href="{{ route('product.applications') }}">Design Intent</a></li>
                  <li><a href="{{ route('site.resources') }}">Resources</a></li>
                  
                </ul>
              </nav>
            </div><!-- menu end here -->
            <div class="header-item header-right-item item-right">
              <!-- mobile menu trigger -->
              <div class="mobile-menu-trigger">
                <span></span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </header>
    <!-- Banner Section -->
    
    <body>
        
        
        
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NC8HPTP9"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->