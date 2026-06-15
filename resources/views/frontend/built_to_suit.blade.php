<!doctype html>
<html lang="en">
    
<head>
   
    <title>{{ $built_to_suit->meta_title }}</title>
    
    <meta name="description" content="{{ $built_to_suit->meta_description ?? 'Default description' }}">
    
    
    @if(!empty($built_to_suit->cannonical))
        {!! $built_to_suit->cannonical !!}
    @endif

    @if(!empty($built_to_suit->hreflang))
        {!! $built_to_suit->hreflang !!}
    @endif

    @if(!empty($built_to_suit->og_tag))
        {!! $built_to_suit->og_tag !!}
    @endif

    @if(!empty($built_to_suit->twitter_card_tag))
        {!! $built_to_suit->twitter_card_tag !!}
    @endif
    
    @include('components.frontend.head')
    
    <style>
        .magnify-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.85);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            overflow: hidden;
        }
        .magnify-overlay img {
            max-width: 90%;
            max-height: 90%;
            cursor: grab;
            transition: transform 0.15s ease-in-out;
        }
        .magnify-overlay img:active {
            cursor: grabbing;
        }
    </style>

</head>
    
    @include('components.frontend.header')



    <section class="breadcrumb-interior-spaces about-breadcrumb" 
         style="background-image: url('{{ asset($built_to_suit->banner_image) }}'); 
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat;">
        <div class="breadcrumb-text">
            <h1>{{ $built_to_suit->banner_heading }}</h1>
        </div>
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-page-name">{{ $built_to_suit->banner_heading }}</li>
            </ul>
        </div>
    </section>


    @php
        $features = json_decode($built_to_suit->features, true) ?? [];
        $sectionImage = $built_to_suit->section_image ?? null;
        $sectionIcon  = $built_to_suit->section_icon ?? null;
    @endphp

    <section class="built-to-wrap">
        <div class="container-fluid">
            <div class="row">
                {{-- First Feature --}}
                @if(isset($features[0]))
                <div class="col-md-4">
                    <div class="solution-text">
                        <div class="vertical-line"></div>
                        <div class="heading">
                            <h2>{{ $features[0]['heading'] }}</h2>
                        </div>
                        <p>{{ $features[0]['description'] }}</p>
                    </div>
                </div>
                @endif

                {{-- Section Image + Icon --}}
                <div class="col-md-4">
                    <div class="solution-img"> 
                        @if($sectionImage)
                            <img src="{{ asset($sectionImage) }}" class="img-responsive solution-img-img" alt="Section Image">
                        @else
                            <img src="images/home/buitto-img.webp" class="img-responsive solution-img-img" alt="">
                        @endif

                        <div class="bottom-fade"></div>

                        @if($sectionIcon)
                            <div class="icon"> 
                                <a class="vid arrow">
                                    <img src="{{ asset($sectionIcon) }}" alt="Section Icon">
                                </a>
                            </div>
                        @else
                            <div class="icon"> 
                                <a class="vid arrow">
                                    <img src="images/icons/light.svg" alt="">
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Second Feature --}}
                @if(isset($features[1]))
                <div class="col-md-4">
                    <div class="solution-text">
                        <div class="vertical-line"></div>
                        <div class="heading">
                            <h2>{{ $features[1]['heading'] }}</h2>
                        </div>
                        <p>{{ $features[1]['description'] }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>


    @php
        $processDetails = json_decode($built_to_suit->process_details, true) ?? [];
    @endphp

    <section class="process-wrap">
        <div class="container">
            <div class="heading heading-center">
                <h2 class="title-anim">Process</h2>
                <p>{{ $built_to_suit->section_description ?? 'Our Built-to-Suit service follows a meticulous process designed to ensure flawless execution:' }}</p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="process-list owl-carousel owl-theme">
                        @foreach($processDetails as $index => $process)
                            <div class="item">
                                <div class="process-item process-items-min-hei">
                                    <div class="icon">
                                        @if(!empty($process['icon']))
                                            <img src="{{ asset($process['icon']) }}" class="img-responsive hvr-icon" alt="{{ $process['title'] }}">
                                        @else
                                            <img src="images/icons/lamp.png" class="img-responsive hvr-icon" alt="{{ $process['title'] }}">
                                        @endif
                                    </div>
                                    <h3>{{ $process['title'] }}</h3>
                                    <p>{{ $process['description'] }}</p>
                                    <!--<a href="service-details.html" class="rmore active">-->
                                    <div class="rmore active">
                                        <div class="arrow">
                                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="br-left-top">
                                            <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                <path d="M11 0L0 0L0 11C0 4.92487 4.92487 0 11 0Z" fill="#afaaa6"></path>
                                            </svg>
                                        </div>
                                        <div class="br-right-bottom">
                                            <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                <path d="M11 0L0 0L0 11C0 4.92487 4.92487 0 11 0Z" fill="#afaaa6"></path>
                                            </svg>
                                        </div>
                                    <!--</a>-->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    
    <section class="projects-page-wrap">
        <div class="container">
            <div class="heading" style="text-align:center;">
                <h2>DOCUMENTATION</h2>
            </div>
            <div class="row">
    
                @php
                    $gallery = json_decode($built_to_suit->gallery, true) ?? [];
                @endphp
    
                @forelse($gallery as $img)
                <div class="col-md-3">
                    <div class="product-item custom-product-item-gallery-sec">
                        <a href="{{ asset($img) }}" class="magnify-popup">
                            <img src="{{ asset($img) }}" class="img-product-img" alt="Gallery Image">
                        </a>
                    </div>
                </div>
                @empty
                <p class="text-center">No images available</p>
                @endforelse
    
            </div>
        </div>
    </section>

    
    <!--<section class="built-gallery-wrap">-->
    <!--    <div class="container">-->
    <!--        <div class="heading heading-center">-->
    <!--            <h2 class="title-anim">-->
    <!--                Our Projects-->
    <!--            </h2>-->
    <!--        </div>-->
    <!--        <div class="row">-->
    <!--            @if($projects->count())-->
    <!--                <div class="col-md-12">-->
    <!--                    <div class="built-gallery-list owl-carousel owl-theme">-->
    <!--                        @foreach($projects as $project)-->
    <!--                            <div class="product-item">-->
    <!--                                <img src="{{ asset($project->thumbnail_image) }}" -->
    <!--                                     class="img-product-img" -->
    <!--                                     alt="{{ $project->project_name }}">-->
    <!--                                <div class="bottom-fade"></div>-->
                
    <!--                                <div class="icon">-->
    <!--                                    <a href="{{ route('projects.details', ['category' => $project->category->slug, 'slug' => $project->slug]) }}" -->
    <!--                                       class="arrow">-->
    <!--                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}" alt="Arrow">-->
    <!--                                    </a>-->
    <!--                                </div>-->
                
    <!--                                <div class="title">-->
    <!--                                    <a href="{{ route('projects.details', ['category' => $project->category->slug, 'slug' => $project->slug]) }}" -->
    <!--                                       class="arrow">-->
    <!--                                        <h4>{{ $project->project_name }}</h4>-->
    <!--                                    </a>-->
    <!--                                    <p>{{ $project->project_location }}</p>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                        @endforeach-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            @else-->
    <!--                <div class="col-12 text-center">-->
    <!--                    <p>No projects available in this category.</p>-->
    <!--                </div>-->
    <!--            @endif-->

    <!--        </div>-->
    <!--    </div>-->
    <!--</section>-->

    
    @include('components.frontend.footer')

    @include('components.frontend.main-js')

    <script>
        $(document).on("click", ".magnify-popup", function (e) {
            e.preventDefault();
        
            var imgSrc = $(this).attr("href");
        
            var popup = `
                <div class="magnify-overlay">
                    <img src="` + imgSrc + `" id="magnify-img" data-scale="1" data-x="0" data-y="0">
                </div>
            `;
            $("body").append(popup);
        });
        
        // Close on click outside
        $(document).on("click", ".magnify-overlay", function (e) {
            if (!$(e.target).is("#magnify-img")) {
                $(".magnify-overlay").remove();
            }
        });
        
        // Zoom using mouse wheel
        $(document).on("wheel", "#magnify-img", function (e) {
            e.preventDefault();
        
            let scale = $(this).data("scale");
            let x = $(this).data("x");
            let y = $(this).data("y");
        
            scale += e.originalEvent.deltaY > 0 ? -0.1 : 0.1;
            scale = Math.max(1, Math.min(scale, 4));
        
            $(this).data("scale", scale);
            $(this).css("transform", `scale(${scale}) translate(${x}px, ${y}px)`);
        });
        
        // Drag Image when zoomed
        let dragging = false;
        let startX, startY;
        
        $(document).on("mousedown", "#magnify-img", function (e) {
            if ($(this).data("scale") <= 1) return;
        
            dragging = true;
            startX = e.clientX;
            startY = e.clientY;
        });
        
        $(document).on("mousemove", function (e) {
            let img = $("#magnify-img");
            if (!dragging || img.data("scale") <= 1) return;
        
            let x = img.data("x");
            let y = img.data("y");
        
            let newX = x + (e.clientX - startX);
            let newY = y + (e.clientY - startY);
        
            img.data("x", newX);
            img.data("y", newY);
        
            startX = e.clientX;
            startY = e.clientY;
        
            img.css("transform", `scale(${img.data("scale")}) translate(${newX}px, ${newY}px)`);
        });
        
        $(document).on("mouseup mouseleave", function () {
            dragging = false;
        });
    </script>

</body>

</html>