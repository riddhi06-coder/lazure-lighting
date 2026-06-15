<!doctype html>
<html lang="en">
    
<head>
    
     <title>Our Journey | Lazure Lighting Since 1974 – 50 Years</title>
    
    <meta name="description" content="Discover Lazure Lighting's journey since 1974 — 50 years of innovation, precision manufacturing and architectural lighting excellence across India and international markets.">
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces about-breadcrumb" style="background-image: url('{{ asset('uploads/about/'.$banner->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">

      <div class="breadcrumb-text">
        <h1>Our Journey</h1>
      </div>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">About Us</a></li>
          <li class="breadcrumb-page-name">Our Journey</li>
        </ul>
      </div>
    </section>


    @if($our_journey->count() > 0)
    <section class="timeline-wrap">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="timeline">

                        @foreach($our_journey as $index => $journey)
                            @php
                                // Alternate left and right classes
                                $positionClass = $index % 2 === 0 ? 'left' : 'right';
                            @endphp

                            <div class="timlinebox {{ $positionClass }}">
                                <div class="timelinecontent">
                                    <div class="timeline-box">
                                        <div class="timeline-heading-icon">
                                            <img src="{{ $journey->heading_icon ? asset('uploads/about/'.$journey->heading_icon) : asset('images/icons/web.png') }}">
                                        </div>
                                        <div class="timeline-heading-text">
                                            <h2>{{ $journey->year }}</h2>
                                            <h4>{{ $journey->achievement }}</h4>
                                        </div>
                                    </div>
                                    <p>{!! $journey->description !!}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif


    @include('components.frontend.footer')
    @include('components.frontend.main-js')

</body>

</html>