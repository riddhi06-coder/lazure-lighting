<!doctype html>
<html lang="en">
    
<head>
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')



    <section class="breadcrumb-interior-spaces" style="background-image: url('{{ asset($banner->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
        <div class="breadcrumb-text">
            <h1>{{ $product->product }}</h1>
        </div>
        <div class="breadcrumb">
            <ul>
                <li><a href="{{ route('frontend.index') }}">Home</a></li>
                <li class="breadcrumb-page-name">
                    <a href="{{ route('products.index') }}" class="second-breadcrumb">Product</a>
                </li>
                <li class="breadcrumb-page-name">
                    <a href="{{ route('applications.list', $application->slug) }}" class="second-breadcrumb">{{ $application->application_type }}</a>
                </li>
                <li class="breadcrumb-page-name">{{ $product->product }}</li>
            </ul>
        </div>

      </div>
    </section>



    <section class="interior-spaces-listing-page-wrap">
      <div class="container">
        <div class="row main-row">

        <!--- FIlters---->
          <div class="col-md-3 main-one">
            <div class="sidebar-main">
              <div class="sidebar">
                <div class="filter-section">
                  <h4>Categories</h4>
                  <ul class="bullets">
                    <li class="bullets-dot"><a href="#">Downlight</a></li>
                    <li class="bullets-dot"><a href="#">Integrated systems</a></li>
                    <li class="bullets-dot"><a href="#">Linears</a></li>
                    <li class="bullets-dot"><a href="#">Suspensions and Creations</a></li>
                    <li class="bullets-dot"><a href="#">Track Mounted</a></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Model Name</h4>
                  <ul class="filter-list">
                    <li><label> <input type="checkbox" name="color" value="blue"> Allura Aperture FIx </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> Allura Aperture Accent </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> Allura Pinhole</label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> Allura Fix  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> Allura Tilt  </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Model No.</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> 1001 </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 1002  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 1003 </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Size</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> Dia 85 x H 106mm </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> Dia 85 x H 90mm  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> Dia 70 x H 82mm </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Wattage</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> 15W </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 10W  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 7W </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Lumens</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> 1325lm </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 1286lm  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 880lm </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>CCT</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> 4000K </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 3000K  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 2700K </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>CRI</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> 95 </label></li>
                    <!--<li><label> <input type="checkbox" name="color" value="blue"> 3000K  </label></li>-->
                    <!--<li><label> <input type="checkbox" name="color" value="blue"> 2700K </label></li>-->
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Beam Angle</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> 60° </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 38°  </label></li>
                    <li><label> <input type="checkbox" name="color" value="blue"> 24° </label></li>
                  </ul>
                </div>
                <div class="filter-section">
                  <h4>Dimming Option</h4>
                  <ul class="filter-list" >
                    <li><label> <input type="checkbox" name="color" value="blue"> Non Dim/Triac Dim/Analog Dim/DALI Dim/DALI Tuneable/RF Tuneable </label></li>
                  </ul>
                </div>
                <div class="apply-reset">
                  <a class="default-btn black-btn">Apply</a>
                  <a class="default-btn black-btn">Reset</a>
                </div>
              </div>
            </div>
          </div>


        <div class="col-md-9 main-two">
            <div class="row">
                @foreach($subproducts as $subproduct)
                    <div class="col-sm-6 col-md-4">
                        <div class="product-item">
                            <img src="{{ asset($subproduct->thumbnail_image) }}" class="img-product-img" alt="{{ $subproduct->sub_product }}">
                            <div class="bottom-fade"></div>
                            <div class="icon">
                                <a href="{{ route('subproduct.detail', [
                                    'application_slug' => $application->slug,
                                    'product_slug' => $product->slug
                                ]) }}" class="arrow">
                                    <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                </a>
                            </div>
                            <div class="title">
                                <a href="{{ route('subproduct.detail', [
                                    'application_slug' => $application->slug,
                                    'product_slug' => $product->slug
                                ]) }}">
                                    <h4>{{ $subproduct->sub_product }}</h4>
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

    @include('components.frontend.footer')


    @include('components.frontend.main-js')

</body>

</html>
