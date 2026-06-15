<!doctype html>
<html lang="en">
    
<head>
    
    @php
        $defaultTitle = "Lighting Product Finder | Find LED Luminaires – Lazure";
        $defaultDesc = "Use Lazure's lighting product finder to discover the right LED luminaires for your project — filter by category, light application, space type and technical requirements.";
    @endphp
    
    @if(!empty($categoryFilter))
    
        {{-- ✅ CATEGORY SEO --}}
        <title>{{ $metaTitle ?: $defaultTitle }}</title>
    
        <meta name="description" content="{{ $metaDescription ?: $defaultDesc }}">
    
        {!! $cannonical !!}
        {!! $hreflang !!}
        {!! $og_tag !!}
        {!! $twitter_card_tag !!}
    
        @elseif(!empty($selectedLightAppId))
        
            {{-- ✅ LIGHT APPLICATION SEO --}}
            <title>{{ $metaTitle1 ?: $defaultTitle }}</title>
        
            <meta name="description" content="{{ $metaDescription1 ?: $defaultDesc }}">
        
            {!! $cannonical1 !!}
            {!! $hreflang1 !!}
            {!! $og_tag1 !!}
            {!! $twitter_card_tag1 !!}
        
        @else
        
            {{-- ✅ DEFAULT SEO --}}
            <title>{{ $defaultTitle }}</title>
        
            <meta name="description" content="{{ $defaultDesc }}">
    
    @endif
    

    
    @include('components.frontend.head')

    <style>

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-item {
            margin-bottom: 15px;
        }

        .filter-item label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .filter-item select {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .filter-section select {
            width: 100%;
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-top: 5px;
        }
        
        
        /*Extra added on 01-12*/
        .product-faq-img-custom-sec {
            width: 150px;
            background-color: #afa6921c;
                /*background-color: rgba(255, 255, 255, 0.7);*/
            border-radius: 10px;
            margin-right: 15px;
        }
        
        .acod-head a {
            font-family: 'Outfit-Medium';
            font-size: 22px;
            font-weight: 500;
            line-height: 1.2;
        }
        
        .acod-head .indicator {
            padding: 12px 20px;
            color: #898989;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            height: auto; /* important: remove the forced 100% height */
        }
        
        .acod-head .indicator img {
           width: 14px;
        }
        
        .mt-accordion .panel .acod-title>a:not(.collapsed) .product-faq-img-custom-sec {
            background-color: rgba(255,255,255, 0.7);
        }
        
        .mt-accordion .panel .acod-title>a:not(.collapsed):hover {
            background-color: #eae5db;
        }

        .acod-head a {
            background-color: transparent;
            border: 1px solid #afa692;
        }
        
        .mt-accordion .panel .acod-title>a:not(.collapsed) {
            background-color: #eae5db;
        }
        
        .mt-accordion .panel .acod-title>a:not(.collapsed) .indicator:before {
            background-color: #eae5db;
        }
        
        .product-name-new-custom-sec {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 28px;
        }
        
        
        /*============*/
        .acod-head {
            position: relative;
        }

        .acod-head .product-faq-img-custom-sec {
            transition: opacity 0.4s ease;
        }

        /* Hide hover image initially */
        .acod-head .hover-img {
            position: absolute;
            left: 15px;
            /*top: 0;*/
            opacity: 0;
        }
        
        /* On hover: show hover image */
        .acod-head:hover .hover-img {
            opacity: 1;
        }

        /* On hover: hide normal image */
        .acod-head:hover .normal-img {
            opacity: 0;
        }
    </style>
    
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces breadcrumb-bg-img-two">
      <div class="breadcrumb-text">
        <h1>Product Finder</h1>
      </div>
      <div class="breadcrumb breadcrumb-main">
        <ul>
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="breadcrumb-page-name"><a href="{{ route('products.index') }}" class="second-breadcrumb">Product</a></li>
          <li class="breadcrumb-page-name">Product Finder</li>
        </ul>
      </div>
    </section>


    <section class="product-listing interior-spaces-page-wrap">
        <div class="container">
            <div class="row">

                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="main-one">
                        <div class="sidebar-main">
                
                
                            <!-- Filter Toggle Button (mobile only) -->
                            <button id="filterBtn" class="mobile-filter-btn default-btn">Filter</button>
                            
                            <div class="sidebar">
                
                                {{-- Main Categories --}}
                                @unless(request()->has('application'))
                                    <div class="filter-section">
                                        <h4>Main Categories</h4>
                                        <ul>
                                            @foreach($applicationTypes as $appType)
                                                <li>
                                                    <label>
                                                        <input type="radio" name="main_category"
                                                            value="{{ $appType->id }}"
                                                            {{ isset($selectedApplicationId) && $selectedApplicationId == $appType->id ? 'checked' : '' }}>
                                                        {{ $appType->application_type }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endunless
                
                
                                {{-- Sub Categories --}}
                                <div class="filter-section">
                                    <h4>Sub Categories</h4>
                                    <select name="sub_category" id="sub_category">
                                        <option value="">Select Sub Category</option>
                                        @foreach($category as $cat)
                                            <option value="{{ $cat->id }}"
                                                data-application-id="{{ $cat->application_id }}"
                                                {{ (isset($categoryFilter) && $categoryFilter == $cat->slug) ? 'selected' : '' }}>
                                                {{ $cat->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                
                
                                {{-- Light Applications --}}
                                <div class="filter-section">
                                    <h4>Light Applications</h4>
                                    <select name="application" id="application" onchange="this.form.submit()">
                                        <option value="">Select Light Applications</option>
                                        @foreach($lightapplicationTypes as $cat)
                                            <option value="{{ $cat->slug }}"
                                                {{ isset($selectedLightAppId) && $selectedLightAppId == $cat->slug ? 'selected' : '' }}>
                                                {{ $cat->light_application_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                
                
                                {{-- Specifications --}}
                                <div class="filter-section">
                                    <h4>Specifications</h4>
                
                                    {{-- Mounting Type --}}
                                    <div class="filter-item">
                                        <label for="mounting_type">Mounting Type</label>
                                        <select name="mounting_type" id="mounting_type">
                                            <option value="">Select</option>
                                            @foreach($mounting_types as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    {{-- IP Rating --}}
                                    <div class="filter-item">
                                        <label for="ip_rating">IP Rating</label>
                                        <select name="ip_rating" id="ip_rating">
                                            <option value="">Select</option>
                                            @foreach($ip_ratings as $ip)
                                                <option value="{{ $ip }}">{{ $ip }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    {{-- Orientation --}}
                                    <div class="filter-item">
                                        <label for="orientation">Orientation</label>
                                        <select name="orientation" id="orientation">
                                            <option value="">Select</option>
                                            @foreach($orientations as $orientation)
                                                <option value="{{ $orientation }}">{{ $orientation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                
                                    {{-- Optics (FIXED) --}}
                                    <div class="filter-item">
                                        <label for="optics">Optics</label>
                                        <select name="optics" id="optics">
                                            <option value="">Select</option>
                                            @foreach($optics as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                
                
                                {{-- Apply / Reset Buttons --}}
                                <div class="apply-reset">
                                    <a href="javascript:void(0)" class="default-btn black-btn" id="apply-filters">Apply</a>
                                    <a href="{{ route('product.finder') }}" class="default-btn black-btn">Reset</a>
                                </div>
                
                            </div>
                
                        </div>
                    </div>
                </div>


                <!-- Products -->
                <div class="col-md-9" id="static-products">
                    
                    @if($products->isNotEmpty())

                        @php
                            $categoryGroups = $products->flatten(1)->groupBy('category');
                        @endphp
                    
                        <div class="faq-1 product-title-custom-sec">
                    
                            @foreach($categoryGroups as $categoryName => $categoryProducts)
                    
                                {{-- CATEGORY HEADING --}}
                                <h2 class="category-heading mb-3">
                                    @if(stripos($categoryName, 'downlights') !== false || stripos($categoryName, 'wall') !== false)
                                        {{ $categoryName }}
                                    @else
                                        {{ trim(str_ireplace('lights', '', $categoryName)) }}
                                    @endif
                                </h2>
                    
                                {{-- Group again by product name inside this category --}}
                                @php
                                    $productGroups = $categoryProducts->groupBy('product');
                                    $index = 1;
                                    
                                  
                                @endphp
                    
                                <div class="mt-accordion acc-bg-white mb-4 panel-group product-faq-custom-sec" id="accordion-{{ Str::slug($categoryName) }}" style="margin-top:20px;">
                    
                                    @foreach($productGroups as $productName => $subProducts)
                                        @php
                                            $productImage = $subProducts[0]->thumbnail_image;
                                            $productImage1 = $subProducts[0]->thumbnail_image1;
                                        @endphp
                                        <div class="panel mt-panel">
                                            <div class="acod-head panel-heading">
                                                <h4 class="acod-title panel-title">
                                                    <a data-toggle="collapse"
                                                           href="#collapse-{{ $index }}-{{ Str::slug($categoryName) }}"
                                                           data-parent="#accordion-{{ Str::slug($categoryName) }}"
                                                           class="collapsed"
                                                           aria-expanded="false">
                                                       <!--image section extra added on 01-12-2025-->
                                                            
                                                        <!-- Normal Image -->
                                                        <img src="{{ asset($productImage) }}"
                                                             alt="{{ $productName }}"
                                                             class="product-faq-img-custom-sec normal-img">
                                    
                                                        <!-- Hover Image -->
                                                        <img src="{{ asset($productImage1) }}"
                                                             alt="{{ $productName }}"
                                                             class="product-faq-img-custom-sec hover-img">    
                                                           
                                                       
                                                       <span class="product-name-new-custom-sec">{{ $productName }}</span>
                                                       <span class="indicator">
                                                           <img src="{{ asset('frontend/assets/images/icons/plus.svg') }}" class="accord-icon">
                                                       </span>
                                                    </a>
                                                </h4>
                                            </div>
                    
                                            <div id="collapse-{{ $index }}-{{ Str::slug($categoryName) }}"
                                                 class="acod-body panel-collapse collapse"
                                                 aria-expanded="false">
                    
                                                <div class="acod-content">
                                                    <div class="row">
                    
                                                        @foreach($subProducts as $subProduct)
                                                            <div class="col-md-4 col-sm-6">
                                                                <div class="product-item">
                                                                    <img src="{{ asset($subProduct->sub_thumbnail ?? $subProduct->thumbnail_image) }}"
                                                                         class="img-product-img"
                                                                         alt="{{ $subProduct->sub_product ?? $productName }}">
                    
                                                                    <div class="bottom-fade"></div>
                    
                                                                    <div class="icon">
                                                                        <a href="{{ route('subproduct.detail', [
                                                                                    $subProduct->application_slug,
                                                                                    $subProduct->category_slug,
                                                                                    $subProduct->sub_product_slug ?? $subProduct->product_slug
                                                                                ]) }}"
                                                                           class="arrow">
                                                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                                                        </a>
                                                                    </div>
                    
                                                                    <div class="title">
                                                                        <a href="{{ route('subproduct.detail', [
                                                                                    $subProduct->application_slug,
                                                                                    $subProduct->category_slug,
                                                                                    $subProduct->sub_product_slug ?? $subProduct->product_slug
                                                                                ]) }}">
                                                                            <h4>{{ $subProduct->sub_product ?? $productName }}</h4>
                                                                        </a>
                                                                    </div>
                    
                                                                </div>
                                                            </div>
                                                        @endforeach
                    
                                                    </div>
                                                </div>
                    
                                            </div>
                                        </div>
                    
                                        @php $index++; @endphp
                    
                                    @endforeach
                    
                                </div>
                    
                            @endforeach
                    
                        </div>
                    
                    @else
                        <div class="no-products text-center py-5">
                            <h3>No products available</h3>
                        </div>
                    @endif

                </div>

                <div class="col-md-9" id="product-listing" style="display:none;">
                    @include('frontend.partials_product_list', ['products' => $products])
                </div>

            </div>
        </div>
    </section>


    
    @include('components.frontend.footer')


    @include('components.frontend.main-js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    
    <!--- For External FIletrs ----->
    <script>
        $(document).ready(function() {

            function filterCombinedDropdowns(category, appId) {
                // Filter sub categories
                $('#sub_category option').each(function() {
                    const optionAppId = $(this).data('application-id');
                    if (!optionAppId || optionAppId == appId) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Filter other dropdowns (Mounting, IP, Orientation, Optics)
                $('select.filter-by-category').each(function() {
                    $(this).find('option').each(function() {
                        const optionCategory = $(this).data('category');
                        if (!category || optionCategory === category || !optionCategory) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            }


            // Listen for main category change
            $('input[name="main_category"]').change(function() {
                const selectedAppId = $(this).val();
                const categoryText = $(this).next().text().trim().toLowerCase(); // interior/exterior

                let category = null;
                if (categoryText.includes('interior')) category = 'interior';
                if (categoryText.includes('exterior')) category = 'exterior';

                filterCombinedDropdowns(category, selectedAppId);
            });

        });
    </script>

    <!----- For Internal filters ------>
    <script>
        $(document).ready(function() {
            $('#apply-filters').on('click', function() {
                let filters = {
                    main_category: $('input[name="main_category"]:checked').val(),
                    sub_category: $('#sub_category').val(),
                    light_application: $('#light_application').val(),
                    mounting_type: $('#mounting_type').val(),
                    ip_rating: $('#ip_rating').val(),
                    orientation: $('#orientation').val(),
                    optics: $('#optics').val(),
                    _token: '{{ csrf_token() }}'
                };

                console.log("Filters Applied:", filters);

                $.ajax({
                    url: "{{ route('products.filter') }}",
                    type: "POST",
                    data: filters,
                    success: function(response) {
                        // Hide the static section no matter what
                        $('#static-products').hide();

                        // Show AJAX container
                        $('#product-listing').show().html(response.html);
                    },
                    error: function(xhr) {
                        console.error("Error:", xhr.responseText);

                        // Optional: show an error message in place of products
                        $('#static-products').hide();
                        $('#product-listing').show().html('<div class="no-products text-center py-5"><h3>Something went wrong. Please try again.</h3></div>');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
    $('#filterBtn').on('click', function () {
        $('.sidebar').toggleClass('active');
    });

    // Apply filters (close sidebar on mobile)
    $('#apply-filters').on('click', function () {
        if ($(window).width() < 769) {
            $('.sidebar').removeClass('active');
        }
    });

    // Close icon
    $('.sidebar-close-btn').on('click', function () {
        $('.sidebar').removeClass('active');
    });
});
    </script>


        

</body>

</html>
