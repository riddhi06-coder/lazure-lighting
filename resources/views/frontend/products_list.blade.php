<!doctype html>
<html lang="en">
    
<head>
    
    
    <title>Architectural LED Luminaires - Lighting Products | Lazure</title>
    
    <meta name="description" content="Lazure's complete range of architectural LED luminaires - interior & exterior lighting products for commercial, hospitality, retail & residential projects.">
    
    <link rel="canonical" href="https://lazurelighting.com/lighting-products" />

    <link rel="alternate" hreflang="en-IN" href="https://lazurelighting.com/in/lighting-products" />
    <link rel="alternate" hreflang="en-GB" href="https://lazurelighting.com/uk/lighting-products" />
    <link rel="alternate" hreflang="en-AE" href="https://lazurelighting.com/ae/lighting-products" />
    <link rel="alternate" hreflang="x-default" href="https://lazurelighting.com/lighting-products" />


    <!-- Open Graph -->
    <meta property="og:title" content="Architectural LED Luminaires | Lighting Products – Lazure" />
    <meta property="og:description" content="Browse Lazure's complete range of architectural LED luminaires — interior and exterior lighting products for commercial, hospitality, retail and developer projects across India and globally." />
    <meta property="og:url" content="https://lazurelighting.com/lighting-products" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="https://lazurelighting.com/frontend/assets/images/home/logo.webp" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:site_name" content="Lazure Lighting" />
    <meta property="og:locale" content="en_IN" />
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Architectural LED Luminaires | Lighting Products – Lazure" />
    <meta name="twitter:description" content="Complete range of architectural LED luminaires — interior and exterior lighting products for commercial, hospitality, retail and developer projects by Lazure." />
    <meta name="twitter:image" content="https://lazurelighting.com/frontend/assets/images/home/logo.webp" />
    <meta name="twitter:site" content="@lazurelighting" />


    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces"     style="background-image: url('{{ asset($banner->banner_image) }}'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;">
        <div class="breadcrumb-text">
            <h1>{{$banner->banner_title}}</h1>
        </div>
        <div class="breadcrumb">
            <ul>
            <li><a href="{{ route('frontend.index') }}">Home</a></li>
            <li class="breadcrumb-page-name"><a href="{{ route('products.index') }}" class="second-breadcrumb">{{$banner->banner_title}}</a></li>
            </ul>
        </div>
    </section>


    <section class="product-listing interior-spaces-page-wrap">
        <div class="container">
            @foreach($products as $applicationType => $categoriesByApp)
                <h1 class="application-heading" style="text-align: center;">
                    <strong>{{ $applicationType }}</strong>
                </h1>
                <br><br>
                <div class="row">
                    @foreach($categoriesByApp as $category)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="product-item">
                                <img src="{{ asset($category->thumbnail_image) }}" 
                                    class="img-product-img" 
                                    alt="{{ $category->category }}">
                                <div class="bottom-fade"></div>
                                <div class="icon">
                                    <a href="{{ route('product.finder', ['category' => $category->slug]) }}" 
                                    class="arrow">
                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                    </a>
                                </div>
                                <div class="title">
                                    <a href="{{ route('product.finder', ['category' => $category->slug]) }}">
                                        <h4>
                                            @if(stripos($category->category, 'downlights') !== false || stripos($category->category, 'wall') !== false)
                                                {{ $category->category }}
                                            @else
                                                {{ trim(str_ireplace('lights', '', $category->category)) }}
                                            @endif
                                        </h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>



    @include('components.frontend.footer')


    @include('components.frontend.main-js')

</body>

</html>