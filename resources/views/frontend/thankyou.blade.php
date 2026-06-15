<!doctype html>
<html lang="en">
    
<head>
    <meta name='robots' content='noindex, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' >
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')
    
    <section class="thank-you-custom-sec">
        <div class="container">
            <div class="col-md-12">
                <div class="thank-you-img-sec">
                    <img src="./public/frontend/assets/images/icons/thank-you-new-one.webp" class="img-fluid" alt="Thank You Image">
                </div>
                <div class="thank-you-content-sec">
                    <div class="heading heading-center">
                        <h2 class="title-anim">Thank You</h2>
                    </div>
                    <p>We appreciate your trust in our services. For any inquiries or updates, please feel free to contact us.</p>
                    <a href="{{ route('frontend.index') }}" class="default-btn black-btn">Back To Home</a>
                </div>
                
            </div>
        </div>            
    </section>
     
     
    @include('components.frontend.footer')
    
    @include('components.frontend.main-js')

</body>

</html>