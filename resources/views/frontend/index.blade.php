<!doctype html>
<html lang="en">
    
<head>
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')


    <!-- Banner Section -->
        <section class="banner-section">
            <div class="banner-carousel owl-carousel owl-theme">
                <!-- Slide Item -->
                <div class="slide-item">
                <div class="image-layer" style="background-image:url('{{ asset('frontend/assets/images/banner/webp/1.webp') }}"></div>
                <div class="content-box">
                    <div class="content">
                    <div class="auto-container">
                        <span class="title">Taj President, Mumbai</span>
                        <h2>Crafting Light,<br> Sculpting Spaces</h2>
                        <div class="btn-box">
                        <a class="default-btn black-btn white-btn">Explore Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Slide Item -->
                <div class="slide-item">
                <div class="image-layer" style="background-image:url('{{ asset('frontend/assets/images/banner/webp/2.webp') }}"></div>
                <div class="content-box">
                    <div class="content">
                    <div class="auto-container">
                        <span class="title">Gorbandh Palace Jaisalmer, India</span>
                        <h2>Engineered to Emulate<br> Sun’s Brilliance</h2>
                        <div class="btn-box">
                        <a class="default-btn black-btn white-btn">Explore Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Slide Item -->
                <div class="slide-item">
                <div class="image-layer" style="background-image:url('{{ asset('frontend/assets/images/banner/webp/3.webp') }}"></div>
                <div class="content-box">
                    <div class="content">
                    <div class="auto-container">
                        <span class="title">Intercontinental, Jaipur</span>
                        <h2>Crafting Light,<br> Sculpting Spaces</h2>
                        <div class="btn-box">
                        <a class="default-btn black-btn white-btn">Explore Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Slide Item -->
                <div class="slide-item">
                <div class="image-layer" style="background-image:url('{{ asset('frontend/assets/images/banner/webp/4.webp') }}"></div>
                <div class="content-box">
                    <div class="content">
                    <div class="auto-container">
                        <span class="title">Sheraton Hotel Whitefield, Bangalore</span>
                        <h2>Engineered to Emulate<br> Sun’s Brilliance</h2>
                        <div class="btn-box">
                        <a class="default-btn black-btn white-btn">Explore Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Slide Item -->
                <div class="slide-item">
                <div class="image-layer" style="background-image:url('{{ asset('frontend/assets/images/banner/webp/5.webp') }}"></div>
                <div class="content-box">
                    <div class="content">
                    <div class="auto-container">
                        <span class="title">Taj Hotel, Bhubaneshwar</span>
                        <h2>Crafting Light,<br> Sculpting Spaces</h2>
                        <div class="btn-box">
                        <a class="default-btn black-btn white-btn">Explore Now</a>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>
    <!--END Banner Section -->

    <section class="product-all-wrap">
      <div class="container">
        <div class="heading heading-center">
          <h2 class="title-anim">Featured Products</h2>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="products owl-carousel owl-theme">
              <div class="item">
                <div class="product-item"> 
                  <img src="{{ asset('frontend/assets/images/home/product1.webp') }}" class="img-product-img" alt="">
                  <div class="bottom-fade"></div>
                  <div class="icon"> 
                    <a href="#" class="arrow">
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a> 
                  </div>
                  <div class="title">
                    <h4>KOSMOS FLEXI WASH</h4>
                    <p>Linear grazer in flexible form with precise optics for curved walls, domes & other such spaces</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item"> 
                  <img src="{{ asset('frontend/assets/images/home/product2.webp') }}" class="img-product-img" alt="">
                  <div class="bottom-fade"></div>
                  <div class="icon"> 
                    <a href="#" class="arrow">
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a> 
                  </div>
                  <div class="title">
                    <h4>JOULE INVI</h4>
                    <p>As thin as it gets, Ultra-thin 10mm magnetic track with multiple modules including grid, diffused & spots</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item"> 
                  <img src="{{ asset('frontend/assets/images/home/product3.webp') }}" class="img-product-img" alt="">
                  <div class="bottom-fade"></div>
                  <div class="icon"> 
                    <a href="#" class="arrow">
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a> 
                  </div>
                  <div class="title">
                    <h4>TENACE</h4>
                    <p>Deep recessed stress free anti-glare fixtures providing great visual comfort</p>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="product-item"> 
                  <img src="{{ asset('frontend/assets/images/home/product4.webp') }}" class="img-product-img" alt="">
                  <div class="bottom-fade"></div>
                  <div class="icon"> 
                    <a href="#" class="arrow">
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a> 
                  </div>
                  <div class="title">
                    <h4>Lorem Impulse</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum standard dummy.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <section class="shock-section">
      <div class="has-overlay"></div>
      <div class="video-wrapper">
        <video class="video vh-85 fit-cover" playsinline autoplay muted loop>
          <source src="{{ asset('frontend/assets/images/video/1.mp4') }}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
      <h2 class="video-title title-anim">Futured-Forward Lighting Design <br> Engineered Today</h2>
    </section>

    <section class="solutions-wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="solution-box interior-box">
              <div class="row vertical-center-row">
                <div class="col-md-6 col-sm-12">
                  <div class="solution-text">
                    <div class="heading">
                      <h2 class="title-anim">Interior Spaces</h2>
                    </div>
                    <div class="desc">
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                    <a class="default-btn black-btn">Explore Now</a>
                    <div class="solution-listing" data-aos="fade-up" data-aos-duration="1500">
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/lamp.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Downlight</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/disruptive-innovation.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Integrated systems</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/web.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Linears</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/light.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Suspensions and Creations</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/track.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Track Mounted</h6></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-12">
                  <div class="solution-img"> 
                    <img src="{{ asset('frontend/assets/images/home/interior-spaces.webp') }}" class="img-responsive solution-img-img" alt="">
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
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="solution-box exterior-box">
              <div class="row vertical-center-row">
                <div class="col-md-6 col-sm-12">
                  <div class="solution-img"> 
                    <img src="{{ asset('frontend/assets/images/home/exterior-spaces.webp') }}" class="img-responsive solution-img-img" alt="">
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
                      <h2 class="title-anim">Exterior Spaces</h2>
                    </div>
                    <div class="desc">
                      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. </p>
                    </div>
                    <a class="default-btn black-btn">Explore Now</a>
                    <div class="solution-listing" data-aos="fade-up" data-aos-duration="1500">
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/burials.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Burials and Underwater</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/pyrotechnics.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Linear Grazers</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/street-lamp.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Pole and Bollards</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/projector.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Projectors</h6></a>
                      </div>
                      <div class="single-solution-item hvr-icon-pop">
                        <img src="{{ asset('frontend/assets/images/icons/wall-lamp.png') }}" class="img-responsive hvr-icon" alt="">
                        <a href="#"><h6>Wall Lights</h6></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <img class="anim-icons" src="{{ asset('frontend/assets/images/bg/pattern.svg') }}" alt="">
    </section>

    <section class="tc-features-st2">
      <div class="container">
        <div class="section-head-st1 col-lg-5">
          <div class="heading">
            <h2 class="title-anim">Built - To - Suit</h2>
            <p>At L'azure, innovation is not just a pursuit; it's our foundation. Our robust Research and Development team stands at the forefront of crafting bespoke lighting solutions tailored to the unique demands of architectural projects.</p>
          </div>  
        </div>
        <div class="cards-box col-lg-9">
          <div class="row justify-content-between">
            <div class="col-lg-5">
              <div class="item">
                <div class="icon">
                  <img src="{{ asset('frontend/assets/images/icons/shining.svg') }}" alt="">
                </div>
                <div class="cont">
                  <h6> Decorative </h6>
                  <div class="txt">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <a class="default-btn white-btn">Explore Now</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="item">
                <div class="icon">
                  <img src="{{ asset('frontend/assets/images/icons/building.svg') }}" alt="">
                </div>
                <div class="cont">
                  <h6> Architectural</h6>
                  <div class="txt">
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    <a class="default-btn white-btn">Explore Now</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <img src="{{ asset('frontend/assets/images/home/feat1.jpg') }}" alt="" class="float-img">
    </section>
    

    <section class="projects-wrap">
      <div class="container">
        <div class="heading heading-center">
          <h2 class="title-anim">Experiences</h2>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="projects-wrap-carousel owl-theme owl-carousel">
              <div class="item">
                <div class="img"> 
                  <img src="{{ asset('frontend/assets/images/projects/03.webp') }}" alt=""> 
                  <div class="bottom-fade"></div>
                </div>
                <div class="con opacity-1">
                  <div class="title">
                    <!-- <h6><span class="et-layers"></span> </h6> -->
                    <h3>Commercial</h3>
                  </div>
                  <div class="icon">
                    <a href="#" class="arrow"> 
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="img"> 
                  <img src="{{ asset('frontend/assets/images/projects/02.webp') }}" alt=""> 
                  <div class="bottom-fade"></div>
                </div>
                <div class="con opacity-1">
                  <div class="title">
                    <!-- <h6><span class="et-layers"></span> </h6> -->
                    <h3>Hospitality</h3>
                  </div>
                  <div class="icon">
                    <a href="#" class="arrow"> 
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="img"> 
                  <img src="{{ asset('frontend/assets/images/projects/01.webp') }}" alt=""> 
                  <div class="bottom-fade"></div>
                </div>
                <div class="con opacity-1">
                  <div class="title">
                    <!-- <h6><span class="et-layers"></span> </h6> -->
                    <h3>Residential</h3>
                  </div>
                  <div class="icon">
                    <a href="#" class="arrow"> 
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="img"> 
                  <img src="{{ asset('frontend/assets/images/projects/04.webp') }}" alt=""> 
                  <div class="bottom-fade"></div>
                </div>
                <div class="con opacity-1">
                  <div class="title">
                    <!-- <h6><span class="et-layers"></span> </h6> -->
                    <h3>Retail</h3>
                  </div>
                  <div class="icon">
                    <a href="#" class="arrow"> 
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                    </a>
                  </div>
                </div>
              </div>
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
              <div class="item">
                <img src="{{ asset('frontend/assets/images/articles/01.webp') }}" class="img-fluid article-img" alt="">
                <div class="bottom-fade"></div>
                <div class="title">
                  <h4>How to furnish and decorate a creative agency</h4>
                </div>
                <div class="icon">
                  <a href="#" class="arrow">
                    <div class="icon-w"> 
                      <i class="icon-show">
                      <span>29<br><i>Apr</i></span>
                      </i>
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}" class="icon-hidden"> 
                    </div>
                  </a>
                </div>
              </div>
              <div class="item">
                <img src="{{ asset('frontend/assets/images/articles/02.webp') }}" class="img-fluid article-img" alt="">
                <div class="bottom-fade"></div>
                <div class="title">
                  <h4>How to create a timeless exterior design</h4>
                </div>
                <div class="icon">
                  <a href="#" class="arrow">
                    <div class="icon-w"> 
                      <i class="icon-show">
                      <span>27<br><i>Apr</i></span>
                      </i>
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}" class="icon-hidden"> 
                    </div>
                  </a>
                </div>
              </div>
              <div class="item">
                <img src="{{ asset('frontend/assets/images/articles/03.webp') }}" class="img-fluid article-img" alt="">
                <div class="bottom-fade"></div>
                <div class="title">
                  <h4>Step by step: planning a web design application</h4>
                </div>
                <div class="icon">
                  <a href="#" class="arrow">
                    <div class="icon-w"> 
                      <i class="icon-show">
                      <span>25<br><i>Apr</i></span>
                      </i>
                      <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}" class="icon-hidden"> 
                    </div>
                  </a>
                </div>
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