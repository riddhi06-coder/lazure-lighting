<!doctype html>
<html lang="en">
    
<head>
    
    <title>{{ $engineering_expertise1->meta_title }}</title>
    
    <meta name="description" content="{{ $engineering_expertise1->meta_description ?? 'Default description' }}">
    
    
    @if(!empty($engineering_expertise1->cannonical))
        {!! $engineering_expertise1->cannonical !!}
    @endif

    @if(!empty($engineering_expertise1->hreflang))
        {!! $engineering_expertise1->hreflang !!}
    @endif

    @if(!empty($engineering_expertise1->og_tag))
        {!! $engineering_expertise1->og_tag !!}
    @endif

    @if(!empty($engineering_expertise1->twitter_card_tag))
        {!! $engineering_expertise1->twitter_card_tag !!}
    @endif
    
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces about-breadcrumb" style="background-image: url('{{ asset('uploads/about/'.$banner->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">>
      <div class="breadcrumb-text">
        <h1>Engineering Expertise</h1>
      </div>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">About Us</a></li>
          <li class="breadcrumb-page-name">Engineering Expertise</li>
        </ul>
      </div>
    </section>


    @if($engineering_expertise->count() > 0)
    <section class="engineering-wrap">
        <div class="container">
            <div class="single-engineering">
                @foreach($engineering_expertise as $index => $item)
                    @php
                        $isEven = $index % 2 === 1;
                    @endphp

                    <div class="row">
                        {{-- If odd index → image left, text right --}}
                        @if(!$isEven)
                            <div class="col-md-6">
                                <div class="item">
                                    <div class="img">
                                        <img src="{{ asset('uploads/about/'.$item->extra_image) }}" alt="" class="img-responsive">
                                    </div>
                                    <div class="bottom-fade"></div>
                                    <div class="con active">
                                        <div class="icon">
                                            <a href="#" class="arrow">
                                                <img src="{{ asset('uploads/about/'.$item->heading_icon) }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="engineering-text">
                                    <h2>{{ $item->heading }}</h2>
                                    <p>{!! $item->description !!}</p>
                                </div>
                            </div>
                        @else
                            {{-- Even index → text left, image right --}}
                            <div class="col-md-6">
                                <div class="engineering-text">
                                    <h2>{{ $item->heading }}</h2>
                                    <p>{!! $item->description !!}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="item">
                                    <div class="img">
                                        <img src="{{ asset('uploads/about/'.$item->extra_image) }}" alt="" class="img-responsive">
                                    </div>
                                    <div class="bottom-fade"></div>
                                    <div class="con active">
                                        <div class="icon">
                                            <a href="#" class="arrow">
                                                <img src="{{ asset('uploads/about/'.$item->heading_icon) }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif



    @include('components.frontend.footer')

    @include('components.frontend.main-js')

</body>

</html>