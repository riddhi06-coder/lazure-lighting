<!doctype html>
<html lang="en">
    
<head>
    
    <title>{{ $category->meta_title }}</title>
    
    <meta name="description" content="{{ $category->meta_description ?? 'Default description' }}">
    
    
    @if(!empty($category->cannonical))
        {!! $category->cannonical !!}
    @endif

    @if(!empty($category->hreflang))
        {!! $category->hreflang !!}
    @endif

    @if(!empty($category->og_tag))
        {!! $category->og_tag !!}
    @endif

    @if(!empty($category->twitter_card_tag))
        {!! $category->twitter_card_tag !!}
    @endif
    
    
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
            <li class="breadcrumb-page-name">{{ $category->category_name }}</li>
            </ul>
        </div>
    </section>

    <section class="projects-page-wrap">
        <div class="container">
            <div class="row">
                @if($projects->count())
                    @foreach($projects as $project)
                        <div class="col-md-6">
                            <div class="product-item">
                                <img src="{{ asset($project->thumbnail_image) }}" class="img-product-img" alt="{{ $project->project_name }}">
                                <div class="bottom-fade"></div>
                                <div class="icon">
                                    <a href="{{ route('projects.details', [ 'category' => $project->category->slug, 'slug' => $project->slug ]) }}" class="arrow">
                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                    </a>
                                </div>
                                <div class="title">

                                   <a href="{{ route('projects.details', [ 'category' => $project->category->slug, 'slug' => $project->slug ]) }}" class="arrow">
                                    <h4>{{ $project->project_name }}</h4></a>
                                    <p>{{ $project->project_location }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>No projects available in this category.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>


    @include('components.frontend.footer')

    @include('components.frontend.main-js')

</body>

</html>