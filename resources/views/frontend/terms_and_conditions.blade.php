<!doctype html>
<html lang="en">
    
<head>
    
     <title>Terms & Conditions | Lazure Lighting</title>
    
    <meta name="description" content="Read Lazure Lighting's terms and conditions — the rules and guidelines governing use of our website, products and services.">
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')
    
    
    <section class="breadcrumb-interior-spaces about-breadcrumb" style="background-image: url('{{ asset('uploads/terms/'.$terms_and_conditions->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
          <div class="breadcrumb-text">
            <h1>{{ $terms_and_conditions->banner_heading }} </h1>
          </div>
          <div class="breadcrumb">
            <ul>
              <li><a href="index.html">Home</a></li>
              <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">{{ $terms_and_conditions->banner_heading }}</a></li>
            </ul>
          </div>
    </section>
    
    <section class="terms-conditions-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="terms-conditions-content-sec">
                        <p><strong>Effective Date: {{ $terms_and_conditions->effective_date }}</strong></p>
                        
                        @foreach($terms_and_conditions_data as $policy)
                            @if($policy->title || $policy->description)
                                <div class="privacy-policy-section terms-cond-last-para">
                                    @if($policy->title)
                                        <h3>{{ $policy->title }}</h3>
                                    @endif
                        
                                    @if($policy->description)
                                        {!! $policy->description !!}
                                    @endif
                                </div>
                            @endif
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