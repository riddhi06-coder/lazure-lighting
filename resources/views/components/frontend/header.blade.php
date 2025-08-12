@php
    $applicationTypes = \DB::table('application_type as at')
        ->join('category as c', 'at.id', '=', 'c.application_id')
        ->select('at.id', 'at.application_type', 'c.category','c.slug')
        ->orderBy('at.id')
        ->wherenull('c.deleted_by')
        ->get()
        ->groupBy('id') // group by application type id
        ->take(2); // first 2 application types



      // Fetch all project names
      $projects = \DB::table('project_category')
        ->select('category_name') // change column name if needed
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
                <a href="{{ route('frontend.index') }}"><img src="{{ asset('frontend/assets/images/home/logo.png') }}"></a>
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
                  <li><a href="{{ route('frontend.index') }}">Home</a></li>


                  <li class="menu-item-has-children">
                    <a href="{{ route('products.index') }}">Products <i class="fa fa-angle-down"></i></a>
                    <div class="sub-menu single-column-menu two-column-menu">
                      <div class="row">
                        <div class="col-md-12">

                          <div class="row">
                              @foreach($applicationTypes as $appId => $categories)
                                  <div class="col-md-6 col-sm-12 list-item border-right-one">
                                      <h3>{{ $categories->first()->application_type }}</h3>
                                      <ul>
                                          @foreach($categories as $cat)
                                              <li><a href="{{ route('category.show', ['slug' => $cat->slug]) }}">{{ $cat->category }}</a></li>
                                          @endforeach
                                      </ul>
                                  </div>
                              @endforeach
                          </div>

                        </div>
                      </div>
                    </div>
                  </li>


                  <li class="menu-item-has-children">
                    <a href="#">Projects <i class="fa fa-angle-down"></i></a>
                    <div class="sub-menu single-column-menu">
                        <ul>
                            @foreach($projects as $project)
                                <li><a href="#">{{ $project->category_name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </li>


                  <li><a href="#">Built-to-suit</a></li>

                  <li class="menu-item-has-children">
                    <a href="#">About Us <i class="fa fa-angle-down"></i></a>
                    <div class="sub-menu single-column-menu">
                      <ul>
                        <li><a href="#">About Lazure Lighting</a></li>
                        <li><a href="#">Our Journey</a></li>
                        <li><a href="#">Engineering Expertise</a></li>
                      </ul>
                    </div>
                  </li>
                  
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