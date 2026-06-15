<!doctype html>
<html lang="en">
    
<head>
    
    <title>Built-to-Suit Project Gallery - Lazure Lighting</title>
    
    <meta name="description" content="View Lazure Lighting's built-to-suit project gallery featuring custom lighting installations for ITC, Hyatt, Taj, Marriott, Sheraton, Hilton, and other landmark properties worldwide.">
    
    @include('components.frontend.head')
    
    <!-- GLightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">


</head>

    
    @include('components.frontend.header')


    @if($projects_banner)
        <section class="breadcrumb-interior-spaces about-breadcrumb"
            style="background-image: url('{{ asset( $projects_banner->banner_image ) }}'); background-size: cover; background-position: center;">
        
            <div class="breadcrumb-text">
                <h1>{{ $projects_banner->banner_heading ?? 'Projects' }}</h1>
            </div>
            <div class="breadcrumb">
                <ul>
                    <li><a href="{{ route('frontend.index') }}">Home</a></li>
                    <li class="breadcrumb-page-name">
                        <a href="#" class="second-breadcrumb">
                            {{ $projects_banner->banner_heading ?? 'Projects' }}
                        </a>
                    </li>
                </ul>
            </div>
        </section>
    @endif


        <section class="projects-page-wrap">
            <div class="container">
                <div class="row">
                    @if($projects->count())
                        @foreach($projects as $project)
                            @php
                                // Decode gallery images JSON
                                $galleryImages = json_decode($project->gallery_images, true) ?? [];
                                // Make full gallery array: thumbnail + gallery images
                                $fullGallery = array_merge([$project->thumbnail_image], $galleryImages);
                            @endphp
        
                            <div class="col-md-6">
    <div class="product-item custom-product-image-sec">

        {{-- Wrap thumbnail, arrow, and name in the same clickable link --}}
        <a href="{{ asset($fullGallery[0]) }}" 
           class="glightbox gallery-{{ $project->id }}"
           data-gallery="gallery-{{ $project->id }}"
           style="display:block; text-decoration:none; color:inherit;">

            {{-- Thumbnail --}}
            <img src="{{ asset($project->thumbnail_image) }}" 
                 class="img-product-img" 
                 alt="{{ $project->project_name }}">
            <div class="bottom-fade"></div>
            {{-- Right arrow over thumbnail --}}
            <div class="icon">
                <span class="custom-gallery-image-icon-sec">
                    <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                </span>
            </div>

            {{-- Project name --}}
            <div class="title">
                <h4>{{ $project->project_name }}</h4>
            </div>

        </a>

        {{-- Hidden gallery images --}}
        @if(count($fullGallery) > 1)
            @foreach(array_slice($fullGallery, 1) as $img)
                <a href="{{ asset($img) }}" 
                   class="glightbox" 
                   data-gallery="gallery-{{ $project->id }}" 
                   style="display:none;"></a>
            @endforeach
        @endif

    </div>
</div>

                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p>No projects available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>





    @include('components.frontend.footer')

    @include('components.frontend.main-js')
    

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    
    <!-- LightSlider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
    
    <script>
        $(document).ready(function() {
    // Initialize GLightbox
    const lightbox = GLightbox({
        selector: '.glightbox',
        loop: true,
        openEffect: 'zoom',
        closeEffect: 'fade'
    });
});
    </script>

</body>

</html>