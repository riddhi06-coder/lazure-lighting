<!doctype html>
<html lang="en">
    
<head>
    
    
     <title>About Lazure Lighting | Laxury Lighting Manufacturer India</title>
    
    <meta name="description" content="Lazure Lighting — founded in 1974, trusted laxury lighting manufacturer with 50+ years of experience. Bespoke, high-performance lighting solutions for architects, designers & developers across India.">
    
    
    @include('components.frontend.head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    
    @verbatim 
        <script type="application/ld+json">
            {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Lazure Lighting",
      "alternateName": "L'azure Lighting",
      "url": "https://lazurelighting.com",
      "logo": {
        "@type": "ImageObject",
        "url": "https://lazurelighting.com/frontend/assets/images/home/logo.webp"
      },
      "image": "https://lazurelighting.com/uploads/home/banner/1765264510314.webp",
      "description": "With over 50 years of experience in the lighting industry, Lazure Lighting is a trusted LED lighting manufacturer and luxury lighting solutions provider committed to quality, precision, and innovation. Having executed 1000+ projects across India and internationally, we specialize in bespoke, high-performance interior and exterior lighting solutions for architects, interior designers, and developers.",
      "foundingDate": "1974",
      "email": "info@lazurelighting.com",
      "telephone": "+91-9876543210",
      "address": [
        {
          "@type": "PostalAddress",
          "name": "L'azure India",
          "streetAddress": "Lotus Link Square, 1703, Near D.N Nagar Metro Station",
          "addressLocality": "Mumbai",
          "addressRegion": "Maharashtra",
          "postalCode": "400053",
          "addressCountry": "IN"
        },
        {
          "@type": "PostalAddress",
          "name": "L'azure UK",
          "streetAddress": "85, Great Portland Street",
          "addressLocality": "London",
          "addressRegion": "England",
          "postalCode": "W1W 7LT",
          "addressCountry": "GB"
        },
        {
          "@type": "PostalAddress",
          "name": "L'azure UAE",
          "streetAddress": "111, Al Fahad 3, Al Qusais",
          "addressLocality": "Dubai",
          "postalCode": "00000",
          "addressCountry": "AE"
        }
      ],
      "location": [
        {
          "@type": "Place",
          "name": "L'azure India",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Lotus Link Square, 1703, Near D.N Nagar Metro Station",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "postalCode": "400053",
            "addressCountry": "IN"
          }
        },
        {
          "@type": "Place",
          "name": "L'azure UK",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "85, Great Portland Street",
            "addressLocality": "London",
            "addressRegion": "England",
            "addressCountry": "GB"
          }
        },
        {
          "@type": "Place",
          "name": "L'azure UAE",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "111, Al Fahad 3, Al Qusais",
            "addressLocality": "Dubai",
            "addressCountry": "AE"
          }
        }
      ],
      "sameAs": [
        "https://www.instagram.com/lazurelighting/",
        "https://www.linkedin.com/company/lazurelighting/"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-9876543210",
        "contactType": "customer service",
        "email": "info@lazurelighting.com",
        "availableLanguage": "English"
      },
      "knowsAbout": [
        "LED Lighting",
        "Luxury Lighting Solutions",
        "Architectural Lighting",
        "Interior Lighting",
        "Exterior Lighting",
        "Custom Lighting Solutions",
        "Lighting Design",
        "Lighting Manufacturing"
      ],
      "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Lighting Products",
      "itemListElement": [
        {
          "@type": "OfferCatalog",
          "name": "Interior Spaces",
          "itemListElement": [
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Downlights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Integrated System Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Linear Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Pendant and Suspension Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Track Mounted Lights" } }
          ]
        },
        {
          "@type": "OfferCatalog",
          "name": "Exterior Spaces",
          "itemListElement": [
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Burial and Underwater Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Linear Grazer Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Pole and Bollard Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Facade Projector Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Wall Lights" } }
          ]
        }
      ]
    },
      "areaServed": [
        { "@type": "Country", "name": "India" },
        { "@type": "Country", "name": "United Kingdom" },
        { "@type": "Country", "name": "United Arab Emirates" },
        { "@type": "AdministrativeArea", "name": "International" }
      ],
      "award": "Lux Futurum Award — for a light-based prototype helping surgeons identify malignant tumours"
    }
        </script>
    @endverbatim


</head>

    
    @include('components.frontend.header')

    <section class="breadcrumb-interior-spaces about-breadcrumb"  
            style="background-image: url('{{ asset('uploads/about/'.$banner->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
      <div class="breadcrumb-text">
        <h1>About Lazure Lighting</h1>
      </div>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">About Us</a></li>
          <li class="breadcrumb-page-name">About Lazure Lighting</li>
        </ul>
      </div>
    </section>

    {{-- First Record Section --}}
    @php
        $first = $about_us->first(); // First record
        $remaining = $about_us->skip(1); // All other records
    @endphp

    <section class="about-page-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="solution-img"> 
                        <img src="{{ asset('uploads/about/'.$first->extra_image) }}" class="img-responsive solution-img-img" alt="">
                        <div class="bottom-fade"></div>
                        <!--<div class="icon"> -->
                        <!--    <a class="vid arrow" href="{{ $first->banner_video ? asset('uploads/about/'.$first->banner_video) : '#' }}">-->
                        <!--        <img src="{{ asset('uploads/about/'.$first->heading_icon) }}">-->
                        <!--    </a>-->
                        <!--</div>-->
                        <div class="title">
                            <h4>{{ $first->image_title }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="solution-text">
                        <div class="heading">
                            <h2 class="title-anim">{{ $first->heading }}</h2>
                        </div>
                        <p>{!! $first->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($remaining->count() > 0)
    <section class="about-two-wrap">
      <div class="container">
        <div class="row">
             @foreach($remaining as $about)
                <div class="col-md-6">
                    <div class="about-two-text">
                        <p>{!! $about->description !!}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-text-text">
                    <div class="heading">
                        <h2 class="title-anim">{{ $about->heading }}</h2>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-two-two-img">
                    <div class="solution-img"> 
                        <img src="{{ asset('uploads/about/'.$about->extra_image) }}" class="img-responsive solution-img-img" alt="">
                        <div class="bottom-fade"></div>
                        <!--<div class="icon"> -->
                        <!--    <a class="vid arrow" href="{{ $about->banner_video ? asset('uploads/about/'.$about->banner_video) : '#' }}">-->
                        <!--        <img src="{{ asset('uploads/about/'.$about->heading_icon) }}">-->
                        <!--    </a>-->
                        <!--</div>-->
                        <div class="title">
                        <h4>{{ $about->image_title }}</h4>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach
        </div>
      </div>
    </section>
    @endif


    @if($banner && $banner->banner_video)
    <section class="video-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="inner-column">
                        <div class="video-box">
                            <figure class="image">
                                <img src="{{ $banner->thumbnail_image ? asset('uploads/about/'.$banner->thumbnail_image) : asset('images/home/video-img.webp') }}" 
                                    alt="{{ $banner->heading ?? 'Video Thumbnail' }}" 
                                    class="img-responsive">
                            </figure>
                            <a href="{{ asset('uploads/about/'.$banner->banner_video) }}" 
                            class="play-now" 
                            data-fancybox="gallery" 
                            data-caption="{{ $banner->heading ?? '' }}">
                                <img src="{{ asset('frontend/assets/images/icons/play-button.svg') }}">
                                <span class="ripple"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @elseif($banner && $banner->youtube_url)
    {{-- ▶️ YouTube Video --}}
    <section class="video-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <iframe 
                        width="100%" 
                        height="500"
                        src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($banner->youtube_url, '/') }}"
                        title="{{ $banner->heading ?? 'YouTube Video' }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    @endif



    @include('components.frontend.footer')

    @include('components.frontend.main-js')

    <script src="{{ asset('frontend/assets/js/jquery.scrollUp.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>


</body>

</html>