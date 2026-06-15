<!doctype html>
<html lang="en">
    
<head>
    
    
     <title>Privacy Policy | Lazure Lighting</title>
    
    <meta name="description" content="Read Lazure Lighting's privacy policy — how we collect, use and protect your personal data when you interact with our website and services.">
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')
    
    
    
    <section class="breadcrumb-interior-spaces about-breadcrumb" style="background-image: url('{{ asset('uploads/privacy/'.$privacy_policy->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
          <div class="breadcrumb-text">
            <h1>{{ $privacy_policy->banner_heading }}</h1>
          </div>
          <div class="breadcrumb">
            <ul>
              <li><a href="{{ url('/') }}">Home</a></li>
              <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">{{ $privacy_policy->banner_heading }}</a></li>
            </ul>
          </div>
    </section>
    
    
    <section class="terms-conditions-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="terms-conditions-content-sec  ck-content">
                        <p><strong>Effective Date: {{ $privacy_policy->effective_date }}</strong></p>
                    
                        @foreach($privacy_policy_data as $policy)
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