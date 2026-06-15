<!doctype html>
<html lang="en">
    
<head>
        
        <title>{{ $productApplication->meta_title }}</title>
        
        <meta name="description" content="{{ $productApplication->meta_description ?? 'Default description' }}">
        
        @if(!empty($productApplication->cannonical))
            {!! $productApplication->cannonical !!}
        @endif
    
        @if(!empty($productApplication->hreflang))
            {!! $productApplication->hreflang !!}
        @endif
    
        @if(!empty($productApplication->og_tag))
            {!! $productApplication->og_tag !!}
        @endif
    
        @if(!empty($productApplication->twitter_card_tag))
            {!! $productApplication->twitter_card_tag !!}
        @endif
    
    @include('components.frontend.head')
    
    <style>
    .product-header-inline {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: nowrap !important;
            gap: 15px;
        }
        
        .product-header-inline h2 {
            white-space: nowrap !important;
            margin: 0 !important;
        }
        
        @media (max-width: 991px) {
            .product-application-wrap {
                position: relative;
            }

            .prod-custom-scroll-col-sec {
                position: sticky;
                top: 80px;
                z-index: 999;
                padding: 0;
                background: #fff;
                border-radius: 10px;
            }

            .product-header-inline {
                position: sticky;
                top: calc(80px + 180px);
                z-index: 998;
                padding: 40px 0 0;
                background: #fff;
            }
        }


    </style>
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces about-breadcrumb" 
             style="background-image: url('{{ asset($productApplication->banner_image) }}'); 
                    background-size: cover; 
                    background-position: center; 
                    background-repeat: no-repeat;">
    
        <div class="breadcrumb-text">
            <h1> Design Intent - {{ $product->product }} </h1>
        </div>
    
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li class="breadcrumb-page-name">
                    <a href="{{ route('product.applications') }}">{{ $product->name }} Design Intent</a>
                </li>

                <li class="breadcrumb-page-name">{{ $product->product }}</li>
            </ul>
        </div>
    </section>


    
    <section class="product-application-wrap">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-sm-12 prod-custom-scroll-col-sec">
                    <div class="product-application-img">
                        @php
                            $onOffImages = json_decode($productApplication->on_off_images ?? '[]', true);
                            $lightImages = json_decode($productApplication->light_images ?? '[]', true);

                            $baseImage = collect($onOffImages)->firstWhere('status', 'off'); // off as base
                            $overlayOnImages = collect($onOffImages)->filter(fn($img) => $img['status'] !== 'off');
                        @endphp

                        <!-- Base image -->
                        @if($baseImage)
                            <img src="{{ asset($baseImage['image']) }}" width="1000px">
                        @endif

                        <!-- On overlay images -->
                        @foreach($overlayOnImages as $img)
                            <img id="{{ $img['status'] }}" class="image-layer" src="{{ asset($img['image']) }}" width="1000px" style="opacity: 0;">
                        @endforeach

                        <!-- Light Application Images -->
                        @foreach($lightImages as $light)
                            <img id="{{ $light['type'] }}" class="image-layer" src="{{ asset($light['image']) }}" width="1000px" style="opacity: 0;">
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4 col-sm-12 prod-custom-scroll-four-col-sec">
                    <div class="product-application-text">
                        
                        <!--<div class="toggle-switch">-->
                        <!--    <label class="btn btn-pill">-->
                        <!--        <input type="checkbox" class="checkbox" id="light-toggle" />-->
                        <!--        <div class="knob"></div>-->
                        <!--        <div class="btn-bg">-->
                        <!--            <span class="label-text" id="toggle-label">OFF</span>-->
                        <!--        </div>-->
                        <!--    </label>-->
                            
                        <!--    <button type="button" id="resetLightImages" class="btn btn-outline-secondary btn-sm" -->
                        <!--          title="Reset Sliders">-->
                        <!--        <i class="fa fa-undo"></i>-->
                        <!--    </button>-->
                            
                        <!--</div>-->

                        <!--<h2>{{ $product->product }}</h2>  -->
                        
                        
                       <div class="product-header-inline">

                            <h2>{{ $product->product }}</h2>
                        
                            <div class="product-on-off-switch-sec d-flex align-items-center gap-2">
                        
                                <label class="btn btn-pill m-0">
                                    <input type="checkbox" class="checkbox" id="light-toggle" />
                                    <div class="knob"></div>
                                    <div class="btn-bg">
                                        <span class="label-text" id="toggle-label">OFF</span>
                                    </div>
                                </label>
                        
                                <button type="button" id="resetLightImages"
                                        class="btn btn-outline-secondary btn-sm product-on-off-reset-sec"
                                        title="Reset Sliders">
                                    <i class="fa fa-undo"></i>
                                </button>
                        
                            </div>
                        
                        </div>


        
                        <h5 style="margin-top: 30px;">{{ $productApplication->section_heading ?? '' }}</h5>
                        
                      
      
                        <h6>{{ $productApplication->section_desc ?? '' }}</h6>
                        
                        
                        <!--<button type="button" id="resetLightImages" class="btn btn-outline-secondary btn-sm" -->
                        <!--      title="Reset Sliders">-->
                        <!--    <i class="fa fa-undo"></i>-->
                        <!--</button>-->

                        <!-- Sliders for overlay images -->
                        <!-- Sliders for Light Application Images only -->
                        <!--@foreach($lightImages ?? [] as $light)-->
                        <!--    <div class="slider-container">-->
                        <!--        <label>{{ $light['type'] }}</label>-->
                        <!--        <input type="range" min="0" max="1" step="0.01" value="0" -->
                        <!--            oninput="updateOpacity('{{ $light['type'] }}', this.value)">-->
                        <!--    </div>-->
                        <!--@endforeach-->
                        
                        
                        <!-- Sliders for Light Application Images only -->
                        @foreach($lightImages ?? [] as $light)
                            <div class="slider-container">
                                <label>{{ $light['type'] }}</label>
                                <input type="range" 
                                       min="0" 
                                       max="1" 
                                       step="0.01" 
                                       value="0" 
                                       oninput="updateOpacity('{{ $light['type'] }}', this.value); showTooltip(this)">
                                <div class="slider-tooltip" style="display: none;" >0%</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('components.frontend.footer')
    
    
    

    @include('components.frontend.main-js')
    
    <script>
        $('#resetLightImages').on('click', function () {
            $('.slider-container input[type="range"]').each(function() {
                $(this).val(0).trigger('input');
                // Hide tooltip after reset
                const tooltip = this.parentElement.querySelector('.slider-tooltip');
                tooltip.style.display = 'none';
            });
        });
    </script>


    <script>
        const toggleCheckbox = document.getElementById('light-toggle');
        const toggleLabel = document.getElementById('toggle-label');

        toggleCheckbox.addEventListener('change', function() {
            const overlayImages = document.querySelectorAll('.image-layer');
            overlayImages.forEach(img => {
                img.style.opacity = this.checked ? 1 : 0; // toggle on/off
            });
            toggleLabel.textContent = this.checked ? 'ON' : 'OFF';
        });

        function updateOpacity(id, value) {
            const img = document.getElementById(id);
            if(img) img.style.opacity = value;
        }
    </script>


    <script>
        function showTooltip(slider) {
            const tooltip = slider.parentElement.querySelector('.slider-tooltip');
            const value = Math.round(slider.value * 100);
            tooltip.textContent = value + '%';
            tooltip.style.display = 'block'; // Show tooltip
            tooltip.style.opacity = 1;
    
            // Position tooltip relative to thumb
            const min = slider.min ? slider.min : 0;
            const max = slider.max ? slider.max : 1;
            const percent = ((slider.value - min) * 100) / (max - min);
            tooltip.style.left = `calc(${percent}% + (${8 - percent * 0.15}px))`;
        }
    </script>
    
    
    <script>
        function updateTooltip(slider) {
          const tooltip = slider.nextElementSibling;
          const value = slider.value;
          tooltip.textContent = value + '%';
          
          const sliderWidth = slider.offsetWidth;
          const thumbOffset = (value / 100) * sliderWidth;
          tooltip.style.left = `${thumbOffset}px`;
        }
    </script>

</body>

</html>
