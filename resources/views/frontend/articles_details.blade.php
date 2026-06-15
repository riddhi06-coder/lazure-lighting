<!doctype html>
<html lang="en">
    
<head>
    
    <title>{{ $article->meta_title }}</title>
    
    <meta name="description" content="{{ $article->meta_description ?? 'Default description' }}">
    
    
    @if(!empty($article->cannonical))
        {!! $article->cannonical !!}
    @endif

    @if(!empty($article->hreflang))
        {!! $article->hreflang !!}
    @endif

    @if(!empty($article->og_tag))
        {!! $article->og_tag !!}
    @endif

    @if(!empty($article->twitter_card_tag))
        {!! $article->twitter_card_tag !!}
    @endif
    
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')
    
    
    
   <section class="breadcrumb-interior-spaces about-breadcrumb" 
             style="background-image: url('{{ asset($article_details->banner_image) }}');
                    background-size: cover; 
                    background-position: center; 
                    background-repeat: no-repeat;">
        <div class="breadcrumb-text">
            <h1>{{ $article->blog_title }}</h1>
        </div>
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-page-name"><a href="{{ route('frontend.articles') }}" class="second-breadcrumb">Blog</a></li>
                <li class="breadcrumb-page-name">Blog Details</li>
            </ul>
        </div>
    </section>

    <section class="blog-details-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2><b>{{ $article_details->blog_heading ?? 'No heading available' }}</b></h2><br>
                    <div class="blog-det-content-sec">
                        <p>{!! $article_details->blog_content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    @include('components.frontend.footer')

    @include('components.frontend.main-js')

</body>

</html>