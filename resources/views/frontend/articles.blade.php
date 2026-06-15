<!doctype html>
<html lang="en">
    
<head>
    
       
    <title>Lighting Articles & Insights | Lazure Lighting Blog</title>
    
    <meta name="description" content="Explore Lazure's lighting articles — expert insights on architectural lighting design, circadian rhythm lighting, technical innovation and lighting applications for commercial & hospitality spaces.">
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')
    
    
    <section class="breadcrumb-interior-spaces about-breadcrumb"  style="background-image: url('{{ asset($articles_banner->banner_image) }}');
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat;">
      <div class="breadcrumb-text">
        <h1>{{ $articles_banner->banner_title }}</h1>
      </div>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-page-name">{{ $articles_banner->banner_title }}</li>
        </ul>
      </div>
    </section>


    <section class="blog blog-one-wrap">
        <div class="container">

            {{-- ========== Articles List ========== --}}
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        @forelse($articles as $article)
                            @php
                                $date = \Carbon\Carbon::parse($article->blog_date);
                                $day = $date->format('d');
                                $month = $date->format('M');
                            @endphp
    
                            <div class="col-lg-4 col-md-12 mb-60">
                                <div class="item">
                                    {{-- Image --}}
                                    @if($article->blog_image)
                                        <img src="{{ asset(  $article->blog_image) }}" 
                                             class="img-fluid" 
                                             alt="{{ $article->title }}">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/placeholder.jpg') }}" 
                                             class="img-fluid" 
                                             alt="No Image">
                                    @endif
    
                                    <div class="bottom-fade"></div>
    
                                    {{-- Title --}}
                                   <!--<div class="title">-->
                                   <!--     <h4>-->
                                   <!--         {{ \Illuminate\Support\Str::words($article->blog_title, 3, '...') }}-->
                                   <!--     </h4>-->
                                   <!-- </div>-->
                                   
                                   <div class="title">
                                        <h4>
                                            <a href="{{ route('frontend.articles_details', $article->slug) }}">
                                                {{ \Illuminate\Support\Str::words($article->blog_title, 3, '...') }}
                                            </a>
                                        </h4>
                                    </div>
    
                                    {{-- Date + Link --}}
                                    <div class="icon">
                                        <a href="{{ route('frontend.articles_details', $article->slug) }}" class="arrow">
                                            <div class="icon-w">
                                                <i class="icon-show">
                                                    <span>{{ $day }}<br><i>{{ $month }}</i></span>
                                                </i>
                                                <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}" class="icon-hidden">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p>No articles found.</p>
                            </div>
                        @endforelse
                    </div>
    
                    {{-- Pagination --}}
                    <div class="row">
                        <div class="col-md-12 text-center mb-30">
                            <ul class="pagination-wrap">
                                {{-- Previous Page Link --}}
                                @if ($articles->onFirstPage())
                                    <li><a href="#"><img src="{{ asset('frontend/assets/images/icons/left-arrow.svg') }}" class="icon-hidden"></a></li>
                                @else
                                    <li>
                                        <a href="{{ $articles->previousPageUrl() }}">
                                            <img src="{{ asset('frontend/assets/images/icons/left-arrow.svg') }}" class="icon-hidden">
                                        </a>
                                    </li>
                                @endif
                    
                                {{-- Pagination Elements --}}
                                @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                                    <li>
                                        <a href="{{ $url }}" class="{{ $articles->currentPage() == $page ? 'active' : '' }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach
                    
                                {{-- Next Page Link --}}
                                @if ($articles->hasMorePages())
                                    <li>
                                        <a href="{{ $articles->nextPageUrl() }}">
                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow.svg') }}" class="icon-hidden">
                                        </a>
                                    </li>
                                @else
                                    <li><a href="#"><img src="{{ asset('frontend/assets/images/icons/right-arrow.svg') }}" class="icon-hidden"></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
    </section>


    @include('components.frontend.footer')

    @include('components.frontend.main-js')

</body>

</html>