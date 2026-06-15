<!doctype html>
<html lang="en">
    
<head>
    
    <title>Lighting Applications - Lazure Lighting Product Finder</title>
    
    <meta name="description" content="Browse Lazure Lighting's full range of light applications - landscape, façade, ambient, task, accent, indirect, underwater, and general lighting - and find the right product for your project.">
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


            
        <section class="breadcrumb-interior-spaces breadcrumb-bg-img-two">
            <div class="breadcrumb-text">
                <h1>Light Application</h1>
            </div>
            <div class="breadcrumb breadcrumb-main">
                <ul>
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li class="breadcrumb-page-name">Light Application</li>
                </ul>
            </div>
        </section>


        
        <section class="product-listing interior-spaces-page-wrap">
            <div class="container">
                <div class="row">
                    @forelse($light_apps_listing as $app)
                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="product-item">
                                <img src="{{ asset($app->thumbnail_image ?? 'frontend/assets/images/default-thumbnail.png') }}" 
                                    class="img-product-img" 
                                    alt="{{ $app->light_application_type ?? 'N/A' }}">
                                <div class="bottom-fade"></div>
                                <div class="icon">
                                    <a href="{{ route('product.finder', ['application' => $app->slug]) }}" class="arrow">
                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                    </a>
                                </div>
                                <div class="title">
                                    <a href="{{ route('product.finder', ['application' => $app->slug]) }}">
                                        <h4>{{ $app->light_application_type ?? 'N/A' }}</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No applications found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>


     @include('components.frontend.footer')


    @include('components.frontend.main-js')

</body>

</html>
