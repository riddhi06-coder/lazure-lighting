<!doctype html>
<html lang="en">
    
<head>
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces" style="background-image: url('{{ asset($banner->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
        <div class="breadcrumb-text">
            <h1>{{ $category->category }}</h1>
        </div>
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li class="breadcrumb-page-name"><a href="{{ route('products.index') }}" class="second-breadcrumb">Product</a></li>
                <li class="breadcrumb-page-name">{{ $category->application_type }}</li>
                <li class="breadcrumb-page-name">{{ $category->category }}</li>
            </ul>
        </div>
    </section>

    <section class="product-listing interior-spaces-page-wrap">
        <div class="container">
            <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-item">
                    <img src="{{ asset($product->thumbnail_image) }}" class="img-product-img" alt="{{ $product->product }}">
                    <div class="bottom-fade"></div>
                    <div class="icon">
                    <a href="{{ route('subproduct.detail', [$product->application_slug, $product->slug]) }}" class="arrow">
                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a>
                    </div>
                    <div class="title">
                    <a href="{{ route('subproduct.detail', [$product->application_slug, $product->slug]) }}">
                        <h4>{{ $product->product }}</h4>
                    </a>
                    </div>
                </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>

    
    @include('components.frontend.footer')


    @include('components.frontend.main-js')

</body>

</html>
