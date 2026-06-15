<!doctype html>
<html lang="en">
    
<head>
    
       
    <title>Lighting Projects by Lazure Lighting - Commercial, Hospitality, Retail & Developers</title>
    
    <meta name="description" content="Explore Lazure Lighting's portfolio of 1000+ executed projects across commercial spaces, hospitality, retail, and developer properties in India and internationally.">
    
    @include('components.frontend.head')
    
    
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces about-breadcrumb">
        <div class="breadcrumb-text">
            <h1>Projects</h1>
        </div>
        <div class="breadcrumb">
            <ul>
            <li><a href="{{ route('frontend.index') }}">Home</a></li>
            <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">Projects</a></li>
            </ul>
        </div>
    </section>

    <section class="projects-page-wrap">
        <div class="container">
            @forelse($categories as $category)
                <div class="col-md-6 col-sm-6 mb-4">
                    <div class="product-item">
                        {{-- Category Image --}}
                        @if($category->banner_image)
                            <img src="{{ asset( $category->banner_image) }}" class="img-product-img" alt="{{ $category->category_name }}">
                        @else
                            <img src="{{ asset('frontend/assets/images/placeholder.jpg') }}" class="img-product-img" alt="No Image">
                        @endif
            
                        <div class="bottom-fade"></div>
            
                        {{-- Link to Category Projects --}}
                        <div class="icon">
                            <a href="{{ route('projects.project_listing', $category->slug) }}" class="arrow">
                                <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                            </a>
                        </div>
            
                        <div class="title">
                            <a href="{{ route('projects.project_listing', $category->slug) }}">
                                <h4>{{ $category->category_name }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No categories available.</p>
                </div>
            @endforelse

        </div>
    </section>




    @include('components.frontend.footer')

    @include('components.frontend.main-js')

</body>

</html>