<!doctype html>
<html lang="en">
    
<head>
    

        <title>Lighting Design Intent - Designer Lights for Architecture | Lazure</title>
        
        <meta name="description" content="Lazure's product range categorisation based on architectural lighting design concepts. Premium designer lights combining precision optics with aesthetic excellence.">

        <link rel="canonical" href="https://lazurelighting.com/design-intent" />

        <link rel="alternate" href="https://lazurelighting.com/design-intent" hreflang="en-in" />
        <link rel="alternate" href="https://lazurelighting.com/design-intent" hreflang="en-gb" />
        <link rel="alternate" href="https://lazurelighting.com/design-intent" hreflang="en-ae" />
        <link rel="alternate" href="https://lazurelighting.com/design-intent" hreflang="x-default" />

        <meta property="og:title" content="Lighting Design Intent - Designer Lights for Architecture - Lazure" />
        <meta property="og:description" content="Lazure's product range categorisation based on architectural lighting design concepts. Premium designer lights combining precision optics with aesthetic excellence." />
        <meta property="og:url" content="https://lazurelighting.com/design-intent" />
        <meta property="og:type" content="website" />
        <meta property="og:locale" content="en_IN" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Lighting Design Intent - Designer Lights for Architecture - Lazure" />
        <meta name="twitter:description" content="Lazure's product range categorisation based on architectural lighting design concepts. Premium designer lights combining precision optics with aesthetic excellence." />
        <meta name="twitter:site" content="@lazurelighting" />
    

    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


    
    
    <section class="breadcrumb-interior-spaces breadcrumb-bg-img-two">
      <div class="breadcrumb-text">
        <h1>Design Intent</h1>
      </div>
      <div class="breadcrumb breadcrumb-main">
        <ul>
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="breadcrumb-page-name">Design Intent</li>
        </ul>
      </div>
    </section>


    <section class="product-listing interior-spaces-page-wrap">
        <!--<div class="container">-->
        <!--    @foreach($product_applications as $productName => $products)-->
        <!--        @if($products->count() > 0)-->
                    <!-- <div class="row"> -->
        <!--                @foreach($products as $product)-->
        <!--                    <div class="col-sm-6 col-md-4 col-lg-3">-->
        <!--                        <div class="product-item">-->
        <!--                            <img src="{{ asset($product->thumbnail_image) }}" -->
        <!--                                class="img-product-img" -->
        <!--                                alt="{{ $product->product }}">-->
        <!--                            <div class="bottom-fade"></div>-->
        <!--                            <div class="icon">-->
        <!--                                <a href="{{ route('applications.details', $product->slug) }}" class="arrow">-->
        <!--                                    <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">-->
        <!--                                </a>-->
        <!--                            </div>-->
        <!--                            <div class="title">-->
        <!--                                <a href="{{ route('applications.details', $product->slug) }}">-->
        <!--                                    <h4>{{ $product->product }}</h4>-->
        <!--                                </a>-->
        <!--                            </div>-->

        <!--                        </div>-->
        <!--                    </div>-->
        <!--                @endforeach-->
                    <!-- </div> -->
        <!--        @endif-->
        <!--    @endforeach-->
        <!--</div>-->
        
        <div class="container">

            @foreach($product_applications as $appId => $products)
        
                @if($products->count() > 0)
                    {{-- Application Type Title --}}
                    <div class="title" style="text-align: center; margin-bottom:20px; margin-top:20px;">
                        <h1>{{ $application_types[$appId] ?? 'Unknown Type' }}</h1>
                    </div>
        
                    {{-- Product Cards --}}
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="product-item">
                                    <img src="{{ asset($product->thumbnail_image) }}" 
                                        class="img-product-img" 
                                        alt="{{ $product->product }}">
        
                                    <div class="bottom-fade"></div>
                                    <div class="icon">
                                        <a href="{{ route('applications.details', $product->slug) }}" class="arrow">
                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                        </a>
                                    </div>
                                    <div class="title">
                                        <a href="{{ route('applications.details', $product->slug) }}">
                                            <h4>{{ $product->product }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
        
                @endif
        
            @endforeach

        </div>


    </section>


    @include('components.frontend.footer')

    @include('components.frontend.main-js')

</body>

</html>
