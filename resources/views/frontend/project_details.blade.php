<!doctype html>
<html lang="en">
    
<head>
    
    <title>{{ $project->meta_title }}</title>
    
    <meta name="description" content="{{ $project->meta_description ?? 'Default description' }}">
    
    
    @if(!empty($project->cannonical))
        {!! $project->cannonical !!}
    @endif

    @if(!empty($project->hreflang))
        {!! $project->hreflang !!}
    @endif

    @if(!empty($project->og_tag))
        {!! $project->og_tag !!}
    @endif

    @if(!empty($project->twitter_card_tag))
        {!! $project->twitter_card_tag !!}
    @endif
    
    
    @include('components.frontend.head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
</head>

    
    @include('components.frontend.header')




    {{-- Breadcrumb --}}
    
    {{-- Project Overview --}}
    @if(!empty($projectDetails->project_image) || !empty($projectDetails->project_title) || !empty($projectDetails->project_description))
        <section class="projects-detail-page-wrap">
            <div class="container">
                <div class="row">
                    @if(!empty($projectDetails->project_image))
                    <div class="col-md-8">
                        <div class="product-detail-img">
                            <img src="{{ asset($projectDetails->project_image) }}" 
                                class="img-responsive" 
                                alt="{{ $projectDetails->project_title }}">
                        </div>
                    </div>
                    @endif

                    @if(!empty($projectDetails->project_title) || !empty($projectDetails->project_description))
                    <div class="col-md-4 product-detail-text-box">
                        <div class="product-detail-text">
                            @if(!empty($projectDetails->project_title))
                            <div class="heading">
                                <h2 class="title-anim">{{ $projectDetails->project_title }}</h2>
                            </div> 
                            @endif

                            @if(!empty($projectDetails->project_description))
                            <p>{!! nl2br(e($projectDetails->project_description)) !!}</p>
                            @endif

                            @if(!empty($projectDetails->additional_description))
                            <p>{!! nl2br(e($projectDetails->additional_description)) !!}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    @endif


    {{-- Project Highlights --}}
    @php 
        $highlights = !empty($projectDetails->highlights) ? json_decode($projectDetails->highlights, true) : [];
    @endphp


    @if(count($highlights))
    <section class="projects-detail-list-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="heading">
                        <h2 class="title-anim">Project Highlights</h2>
                    </div> 
                </div>
            </div>

            @php
                $half = ceil(count($highlights) / 2);
                $firstHalf = array_slice($highlights, 0, $half);
                $secondHalf = array_slice($highlights, $half);
            @endphp

            <div class="row">
                <div class="col-md-6">
                    <div class="projects-detail-list"> 
                        <ul class="listing">
                            @foreach($firstHalf as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="projects-detail-list"> 
                        <ul class="listing">
                            @foreach($secondHalf as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif


    @php 
        $galleryImages = !empty($projectDetails->gallery_images) ? json_decode($projectDetails->gallery_images, true) : [];
    @endphp

    @if(count($galleryImages))
    <section class="gallery-wrap">
        <div class="container-fluid">
            <div class="heading heading-center">
                <h2 class="title-anim">Gallery</h2>
            </div> 

            <div class="row">
                @foreach($galleryImages as $image)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <a href="{{ asset($image) }}" data-fancybox="gallery" class="gallery-hover">
                            <img src="{{ asset($image) }}" class="img-responsive" alt="Project Image">
                            <div class="overlay">
                                <span class="plus-icon">+</span>
                            </div>
                        </a>
                    </div>
                @endforeach
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