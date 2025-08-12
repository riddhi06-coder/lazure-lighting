<!doctype html>
<html lang="en">
    
<head>
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')

    <!-- Banner Section -->
        <section class="banner-section">
            <div class="banner-carousel owl-carousel owl-theme">
                @foreach($banners as $banner)
                    <div class="slide-item">
                        <div class="image-layer" 
                            style="background-image:url('{{ asset('uploads/home/banner/' . $banner->banner_images) }}')">
                        </div>

                        <div class="content-box">
                            <div class="content">
                                <div class="auto-container">
                                    <span class="title">{{ $banner->banner_heading }}</span>
                                    <h2>{!! nl2br(e($banner->banner_title)) !!}</h2>
                                    <div class="btn-box">
                                        <a href="#" class="default-btn black-btn white-btn">Explore Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    <!--END Banner Section -->

    <section class="product-all-wrap">
        <div class="container">
            <div class="heading heading-center">
                <h2 class="title-anim">
                    {{ $featuredProducts->first()->section_heading ?? 'Featured Products' }}
                </h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="products owl-carousel owl-theme">
                        @foreach($featuredProducts as $product)
                            <div class="item">
                                <div class="product-item"> 
                                    <img src="{{ asset('uploads/home/featured/' . $product->banner_images) }}" 
                                        class="img-product-img" alt="{{ $product->banner_heading }}">
                                    <div class="bottom-fade"></div>
                                    <div class="icon"> 
                                        <a href="#" class="arrow">
                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                        </a> 
                                    </div>
                                    <div class="title">
                                        <h4>{{ $product->banner_heading }}</h4>
                                        <p>{{ $product->banner_title }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($advertisement))
        @php
            $words = explode(' ', $advertisement->banner_title);
            if (count($words) > 2) {
                $lastTwoWords = array_splice($words, -2);
                $formattedTitle = implode(' ', $words) . '<br>' . implode(' ', $lastTwoWords);
            } else {
                $formattedTitle = $advertisement->banner_title; // No change if only 2 or fewer words
            }
        @endphp

        <section class="shock-section">
            <div class="has-overlay"></div>
            <div class="video-wrapper">
                <video class="video vh-85 fit-cover" playsinline autoplay muted loop>
                    <source src="{{ asset('uploads/home/advertise/' . $advertisement->video) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <h2 class="video-title title-anim">
                {!! $formattedTitle !!}
            </h2>
        </section>
    @endif

    <section class="solutions-wrap">
        <div class="container">
            <div class="row">
                @foreach($firstSection as $index => $intro)
                    <div class="col-md-12">
                        <div class="solution-box {{ strtolower($intro->applicationType->application_type) }}-box">
                            <div class="row vertical-center-row">

                                {{-- Text Left / Image Right for even index --}}
                                @if($index % 2 == 0)
                                    <div class="col-md-6 col-sm-12">
                                        <div class="solution-text">
                                            <div class="heading">
                                                <h2 class="title-anim">{{ $intro->applicationType->application_type }}</h2>
                                            </div>
                                            <div class="desc">
                                                <p>{!! $intro->application_info !!}</p>
                                            </div>
                                            <a class="default-btn black-btn">Explore Now</a>
                                            <div class="solution-listing" data-aos="fade-up" data-aos-duration="1500">
                                                @foreach($intro->details as $detail)
                                                    <div class="single-solution-item hvr-icon-pop">
                                                        <img src="{{ asset($detail['icon']) }}" class="img-responsive hvr-icon" alt="">
                                                        <a href="#"><h6>{{ $detail['title'] }}</h6></a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="solution-img">
                                            <img src="{{ asset($intro->banner_image) }}" class="img-responsive solution-img-img" alt="">
                                            <div class="bottom-fade"></div>
                                            <div class="icon">
                                                <a href="#" class="vid arrow">
                                                    <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                                </a>
                                            </div>
                                            <div class="title">
                                                <h4>Explore More</h4>
                                            </div>
                                        </div>
                                    </div>

                                {{-- Image Left / Text Right for odd index --}}
                                @else
                                    <div class="col-md-6 col-sm-12">
                                        <div class="solution-img">
                                            <img src="{{ asset($intro->banner_image) }}" class="img-responsive solution-img-img" alt="">
                                            <div class="bottom-fade"></div>
                                            <div class="icon">
                                                <a href="#" class="vid arrow">
                                                    <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                                </a>
                                            </div>
                                            <div class="title">
                                                <h4>Explore More</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="solution-text">
                                            <div class="heading">
                                                <h2 class="title-anim">{{ $intro->applicationType->application_type }}</h2>
                                            </div>
                                            <div class="desc">
                                                <p>{!! $intro->application_info !!}</p>
                                            </div>
                                            <a class="default-btn black-btn">Explore Now</a>
                                            <div class="solution-listing" data-aos="fade-up" data-aos-duration="1500">
                                                @foreach($intro->details as $detail)
                                                    <div class="single-solution-item hvr-icon-pop">
                                                        <img src="{{ asset($detail['icon']) }}" class="img-responsive hvr-icon" alt="">
                                                        <a href="#"><h6>{{ $detail['title'] }}</h6></a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <img class="anim-icons" src="{{ asset('frontend/assets/images/bg/pattern.svg') }}" alt="">
    </section>

    <section class="tc-features-st2">
        <div class="container">
            <div class="section-head-st1 col-lg-5">
                @if($secondSection->isNotEmpty())
                    <div class="heading">
                        <h2 class="title-anim">{{ $secondSection->first()->applicationType->application_type }}</h2>
                        <p>{!! $secondSection->first()->application_info !!}</p>
                    </div>
                @endif
            </div>

            <div class="cards-box col-lg-9">
                <div class="row justify-content-between">
                    @foreach($secondSection as $intro)
                        @if(!empty($intro->details))
                            @foreach($intro->details as $detail)
                                <div class="col-lg-5">
                                    <div class="item">
                                        <div class="icon">
                                            <img src="{{ asset($detail['icon']) }}" alt="{{ $detail['title'] }}">
                                        </div>
                                        <div class="cont">
                                            <h6>{{ $detail['title'] }}</h6>
                                            <div class="txt">
                                                <p>{{ $detail['description'] }}</p>
                                                <a class="default-btn white-btn">Explore Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>

        </div>

        @if($secondSection->isNotEmpty())
            <img src="{{ asset($secondSection->first()->banner_image) }}" alt="" class="float-img">
        @endif
    </section>

    <section class="projects-wrap">
        <div class="container">
            <div class="heading heading-center">
                <h2 class="title-anim">Experiences</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="projects-wrap-carousel owl-theme owl-carousel">
                        @foreach($projectCategories as $category)
                            <div class="item">
                                <div class="img"> 
                                    <img src="{{ asset($category->banner_image) }}" alt="{{ $category->category_name }}">
                                    <div class="bottom-fade"></div>
                                </div>
                                <div class="con opacity-1">
                                    <div class="title">
                                        <h3>{{ $category->category_name }}</h3>
                                    </div>
                                    <div class="icon">
                                        <a href="#" class="arrow"> 
                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="articales-wrap">
        <div class="container-fluid">
            <div class="heading heading-center">
                <h2 class="title-anim">Featured Articles</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="articales-carousel owl-theme owl-carousel">
                        @foreach($blogs as $blog)
                            <div class="item">
                                <img src="{{ asset($blog->blog_image) }}" class="img-fluid article-img" alt="{{ $blog->blog_title }}">
                                <div class="bottom-fade"></div>
                                <div class="title">
                                    <h4>{{ $blog->blog_title }}</h4>
                                </div>
                                <div class="icon">
                                    <a href="#" class="arrow">
                                        <div class="icon-w"> 
                                            <i class="icon-show">
                                                @php
                                                    $date = \Carbon\Carbon::parse($blog->blog_date);
                                                @endphp
                                                <span>{{ $date->format('d') }}<br><i>{{ $date->format('M') }}</i></span>
                                            </i>
                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}" class="icon-hidden"> 
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.frontend.footer')


    @include('components.frontend.main-js')




</body>

</html>