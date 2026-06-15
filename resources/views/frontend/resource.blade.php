<!doctype html>
<html lang="en">
    
<head>
    
    <title>Lighting Resources | Spec Sheets & Manuals – Lazure</title>
    
    <meta name="description" content="Access Lazure's lighting resources — download product spec sheets, 2D drawings and installation manuals for the complete range of interior and exterior LED luminaires.">
    
    
    @include('components.frontend.head')
    <style>
        .projects-page-wrap .product-item img.img-product-img {
            height: 360px;
            object-fit: contain;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
    
    

</head>

    
    @include('components.frontend.header')
    
    
    <section class="breadcrumb-interior-spaces about-breadcrumb">
        <div class="breadcrumb-text">
            <h1>Resources</h1>
        </div>
        <div class="breadcrumb">
            <ul>
            <li><a href="{{ route('frontend.index') }}">Home</a></li>
            <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">Resources</a></li>
            </ul>
        </div>
    </section>
    
    
    <section class="projects-page-wrap">
        <div class="container">
    
            <!-- ================= CATALOG SECTION ================= -->
            @if($catalog->count())
                <div class="title" style="text-align: center; margin-bottom:20px; margin-top:5px;">
                    <h1>Full Catalog</h1>
                </div>
            
                <div class="row">
                    @foreach($catalog as $item)
                        <div class="col-md-4 col-sm-4 mb-4" style="margin-top:20px;">
                            <div class="product-item openInquiryModal"
                                 data-type="Full Catalog"
                                 data-file="{{ $item->document_file }}">
            
                                @if($item->thumbnail_image)
                                    <img src="{{ asset($item->thumbnail_image) }}" class="img-product-img">
                                @else
                                    <img src="{{ asset('frontend/assets/images/placeholder.jpg') }}" class="img-product-img">
                                @endif
            
                                <div class="bottom-fade"></div>
            
                                <div class="icon">
                                    <a href="#" class="arrow">
                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                    </a>
                                </div>
            
                                <div class="title">
                                    <h4 class="openInquiryModal">{{ $item->section_title }}</h4>
                                </div>
            
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

    
            <!-- ================= INDIVIDUAL CATALOG SECTION ================= -->
    
            @if($individual_catalog->count())
                <div class="title" style="text-align: center; margin-bottom:20px; margin-top:20px;">
                    <h1>Individual Series Catalog</h1>
                </div>
                
                <div class="row">
                    @foreach($individual_catalog as $item)
                        <div class="col-md-4 col-sm-4 mb-4">
                            <div class="product-item openInquiryModal"
                                 data-type="Individual Series Catalog"
                                 data-file="{{ $item->document_file }}">
            
                                @php
                                    // Check if a product thumbnail exists for this section_title
                                    $productThumbnail = $products[$item->section_title] ?? null;
                                @endphp
            
                                @if($productThumbnail)
                                    <img src="{{ asset($productThumbnail) }}" class="img-product-img">
                                @elseif($item->thumbnail_image)
                                    <img src="{{ asset($item->thumbnail_image) }}" class="img-product-img">
                                @else
                                    <img src="{{ asset('frontend/assets/images/placeholder.jpg') }}" class="img-product-img">
                                @endif
            
                                <div class="bottom-fade"></div>
            
                                <div class="icon">
                                    <a href="#" class="arrow">
                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                    </a>
                                </div>
            
                                <div class="title">
                                    <h4 class="openInquiryModal">{{ $item->section_title }}</h4>
                                </div>
            
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

    
            <!-- ================= BROCHURE SECTION ================= -->
            
            @if($brochure->count())
                <div class="title" style="text-align: center; margin-bottom:20px; margin-top:20px;">
                    <h1>Brochure</h1>
                </div>
                
                <div class="row">
                    @foreach($brochure as $item)
                        <div class="col-md-4 col-sm-4 mb-4">
                            <div class="product-item openInquiryModal"
                                 data-type="Brochure"
                                 data-file="{{ $item->document_file }}">
            
                                @if($item->thumbnail_image)
                                    <img src="{{ asset($item->thumbnail_image) }}" class="img-product-img">
                                @else
                                    <img src="{{ asset('frontend/assets/images/placeholder.jpg') }}" class="img-product-img">
                                @endif
            
                                <div class="bottom-fade"></div>
            
                                <div class="icon">
                                    <a href="#" class="arrow">
                                        <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                    </a>
                                </div>
            
                                <div class="title">
                                    <h4 class="openInquiryModal">{{ $item->section_title }}</h4>
                                </div>
            
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

    
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="team1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Download Brochure</h4>
          </div>
          <div class="modal-body">
            <div class="contact-form-box">
                <form id="contactForm" action="{{ route('brochure.download') }}" method="post">
                    
                    <input type="hidden" name="document_type" id="documentType">
                    <input type="hidden" name="document_path" id="documentPath">
                    <input type="hidden" name="document_title" id="documentTitle">


                    @csrf

                    <div class="form-group col-md-6">
                        <label>First Name <span>*</span></label>
                        <input type="text" name="first_name" class="form-control">
                        <small class="text-danger error-msg"></small>
                    </div>
                
                    <div class="form-group col-md-6">
                        <label>Last Name <span>*</span></label>
                        <input type="text" name="last_name" class="form-control">
                        <small class="text-danger error-msg"></small>
                    </div>
                
                    <div class="form-group col-md-6">
                        <label>Email <span>*</span></label>
                        <input type="email" name="email_id" class="form-control">
                        <small class="text-danger error-msg"></small>
                    </div>
                
                    <div class="form-group col-md-6">
                        <label>Phone Number <span>*</span></label>
                        <input type="text" name="phone_number" class="form-control">
                        <small class="text-danger error-msg"></small>
                    </div>
                    
                    <div class="col-md-12 form-group text-center">
                        <div style="display: inline-block;">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        </div>
                        <div id="captchaError" class="error" style="color:red; margin-top: 5px;"></div>
                    </div>
                
                    <div class="form-group text-center col-md-12">
                        <button type="submit" class="default-btn black-btn" id="formSubmitBtn">Submit</button>
                    </div>
                </form>

            </div>
          </div>
        </div>
      </div>
    </div>


    <div id="downloadLoader" style="
        display:none;
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background:rgba(0,0,0,.7);
        z-index:9999;
        align-items:center;
        justify-content:center;
    ">

    <div style="text-align:center;">

        <!-- Spinner -->
        <div style="
        width:60px;
        height:60px;
        border:5px solid #ffffff33;
        border-top:5px solid #fff;
        border-radius:50%;
        animation:spin 1s linear infinite;
        margin:auto;"></div>

        <!-- Text -->
        <div style="
        margin-top:15px;
        color:#fff;
        font-size:18px;
        letter-spacing:1px;">
            Preparing your download…
        </div>

    </div>

</div>


    @include('components.frontend.footer')

    @include('components.frontend.main-js')
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
         
    <!--<script>-->
    <!--    document.querySelectorAll('.openInquiryModal').forEach(function(el) {-->
    <!--        el.addEventListener('click', function() {-->
    <!--            const type = el.getAttribute('data-type');-->
    <!--            const file = el.getAttribute('data-file');-->
    <!--            const title = el.querySelector('h4').innerText;-->
        
    <!--            document.getElementById('documentType').value = type;-->
    <!--            document.getElementById('documentPath').value = file;-->
    <!--            document.getElementById('documentTitle').value = title;-->
        
                // Open the modal
    <!--            $('#team1').modal('show');-->
    <!--        });-->
    <!--    });-->

    <!--</script>-->


    <script>
        document.querySelectorAll('.openInquiryModal').forEach(function(el) {
    
        el.addEventListener('click', function(e) {
            e.preventDefault();
    
            const type  = el.getAttribute('data-type');
            const file  = el.getAttribute('data-file');
            const title = el.querySelector('h4') ? el.querySelector('h4').innerText : '';
    
            // ✅ FULL + INDIVIDUAL SERIES CATALOG → DIRECT DOWNLOAD
            if (type === 'Full Catalog' || type === 'Individual Series Catalog' || type === 'Brochure') {
    
                if (file) {
    
                    // Show loader
                    document.getElementById('downloadLoader').style.display = 'flex';
    
                    const link = document.createElement('a');
                    link.href = "{{ asset('') }}" + file;
                    link.download = file.split('/').pop();
    
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
    
                    // Hide loader after small delay
                    setTimeout(function() {
                        document.getElementById('downloadLoader').style.display = 'none';
                    }, 1500);
                }
    
                return;
            }
    
            // ✅ BROCHURE → OPEN MODAL
            document.getElementById('documentType').value = type;
            document.getElementById('documentPath').value = file;
            document.getElementById('documentTitle').value = title;
    
            $('#team1').modal('show');
        });
    
    });
    </script>


    
    <!--- Form validations---->
    <script>
        document.getElementById("contactForm").addEventListener("submit", function(e) {
            let valid = true;
        
            // Clear previous errors
            document.querySelectorAll(".error-msg").forEach(el => el.innerText = "");
        
            const firstName = document.querySelector('input[name="first_name"]');
            const lastName = document.querySelector('input[name="last_name"]');
            const email = document.querySelector('input[name="email_id"]');
            const phone = document.querySelector('input[name="phone_number"]');
        
            // Name validation – Only letters
            const nameRegex = /^[A-Za-z]+$/;
            if (firstName.value.trim() === "" || !nameRegex.test(firstName.value)) {
                showError(firstName, "Please enter a valid first name");
                valid = false;
            }
            if (lastName.value.trim() === "" || !nameRegex.test(lastName.value)) {
                showError(lastName, "Please enter a valid last name");
                valid = false;
            }
        
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === "" || !emailRegex.test(email.value)) {
                showError(email, "Please enter a valid email address");
                valid = false;
            }
        
            // Phone validation – 10 digits only
            const phoneRegex = /^[0-9]{10,15}$/;
            if (!phoneRegex.test(phone.value)) {
                showError(phone, "Enter a valid 10-15 digit phone number");
                valid = false;
            }
        
            // ⭐ reCAPTCHA v2 validation ⭐
            let captcha = grecaptcha.getResponse();
            if (captcha.length === 0) {
                document.getElementById("captchaError").innerHTML = "Please verify that you are not a robot.";
                valid = false;
            }
        
            if (!valid) {
                e.preventDefault();
            } else {
                const submitBtn = document.getElementById("formSubmitBtn");
                submitBtn.disabled = true;
                submitBtn.innerText = "Submitting...";
            }
        });
        
        function showError(inputElement, message) {
            const errorField = inputElement.parentElement.querySelector(".error-msg");
            errorField.innerText = message;
        }
    </script>
    
    <!--- For document Download---->
    @if(request('download'))
        <script>
            const link = document.createElement('a');
            link.href = "{{ asset(request('download')) }}";
            link.download = "";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        
            // Remove download query from URL
            const url = new URL(window.location);
            url.searchParams.delete('download');
            window.history.replaceState({}, document.title, url.toString());
        </script>
    @endif




</body>

</html>