<!doctype html>
<html lang="en">
    
<head>
    
    <title>Careers at Lazure Lighting - Join Our Lighting Design Team</title>
    
    <meta name="description" content="Explore career opportunities at Lazure Lighting. We're hiring Lighting Designers, Project Managers, and Sales Engineers passionate about design, precision, and innovation.">
    
    
    
    @include('components.frontend.head')
</head>

    
    @include('components.frontend.header')



    <section class="breadcrumb-interior-spaces about-breadcrumb" style="background-image: url('{{ asset('uploads/career/' . $careers->banner_image) }}'); 
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat;"> 
          <div class="breadcrumb-text">
            <h1>{{ $careers->banner_heading }}</h1>
          </div>
          <div class="breadcrumb">
            <ul>
              <li><a href="index.html">Home</a></li>
              <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">{{ $careers->banner_heading }}</a></li>
              <!--<li class="breadcrumb-page-name">About Lazure Lighting</li>-->
            </ul>
          </div>
    </section>

    
    <section class="about-page-wrap careers-page-one-wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="solution-img"> 
              <img src="{{ asset('uploads/career/' . $careers->section_image) }}" class="img-responsive solution-img-img" alt="">
              <div class="bottom-fade"></div>
                <div class="icon"> 
                  <a class="vid arrow">
                    <img src="{{ asset('frontend/assets/images/icons/light.svg' ) }}">
                  </a>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="solution-text">
              <div class="heading">
                <h2 class="title-anim">{{ $careers->section_title }}</h2>
              </div>
              <p>{{ $careers->section_description }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    
    <section class="process-wrap careers-our-values-wrap">
        <div class="container">
            <div class="heading heading-center">
                <h2 class="title-anim">{{ $careers->value_heading }}</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="process-list owl-carousel owl-theme">
    
                        @php
                            $values = json_decode($careers->our_values, true);
                        @endphp
    
                        @if($values && count($values) > 0)
                            @foreach($values as $index => $value)
                                <div class="item">
                                    <div class="process-item">
                                        <div class="icon">
                                            @if(isset($value['icon']) && $value['icon'])
                                                <img src="{{ asset('uploads/career/' . $value['icon']) }}" class="img-responsive hvr-icon" alt="{{ $value['title'] }}">
                                            @else
                                                <img src="images/icons/lamp.png" class="img-responsive hvr-icon" alt="{{ $value['title'] }}">
                                            @endif
                                        </div>
                                        <h3>{{ $value['title'] }}</h3>
                                        <p>{{ $value['description'] }}</p>
                                        <a href="service-details.html" class="rmore active">
                                            <div class="arrow">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                                            <div class="br-left-top">
                                                <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                    <path d="M11 0L0 0L0 11C4.92487 11 11 4.92487 11 0Z" fill="#afaaa6"></path>
                                                </svg>
                                            </div>
                                            <div class="br-right-bottom">
                                                <svg viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-11 h-11">
                                                    <path d="M11 0L0 0L0 11C4.92487 11 11 4.92487 11 0Z" fill="#afaaa6"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No values added yet.</p>
                        @endif
    
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-page-wrap careers-page-three-wrap">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="solution-text">
                <div class="heading">
                    <h2 class="title-anim">Why Join Us</h2>
                </div>
            
                @php
                    $features = json_decode($careers->join_features, true);
                    $icons = ['one-icon.png', 'two-icon.png', 'three-icon.png', 'four-icon.png', 'five-icon.png']; // fallback icons
                @endphp
            
                @if($features && count($features) > 0)
                    @foreach($features as $index => $feature)
                        <div class="careers-why-us-number-sec">
                            <div class="carr-whyus-img-sec">
                                @if(isset($icons[$index]))
                                    <img src="{{ asset('frontend/assets/images/icons/' . $icons[$index]) }}" alt="Feature {{ $index + 1 }}">
                                @else
                                    <img src="{{ asset('images/icons/default-icon.png') }}" alt="Feature {{ $index + 1 }}">
                                @endif
                            </div>
                            <p>{{ $feature }}</p>
                        </div>
                    @endforeach
                @else
                    <p>No features added yet.</p>
                @endif
            </div>

          </div>
          
          <div class="col-md-6">
            <div class="solution-img"> 
              <img src="{{ asset('uploads/career/' . $careers->section_icon) }}" class="img-responsive solution-img-img" alt="">
              <div class="bottom-fade"></div>
                <div class="icon"> 
                  <a class="vid arrow">
                    <img src="{{ asset('frontend/assets/images/icons/light.svg') }}">
                  </a>
                </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    
    
    <section class="faq-one-sec">
        <div class="container">
            <div class="heading">
                <h2 class="title-anim">Current Openings</h2>
            </div>
            <div class="panel-group" id="accordionExample">
                @foreach($jobs as $index => $job)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" 
                                   data-parent="#accordionExample" 
                                   href="#collapse{{ $index }}" 
                                   class="full-btn {{ $index !== 0 ? 'collapsed' : '' }}">
                                    {{ $job->job_role }}
                                    <i class="fa fa-chevron-down arrow"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse{{ $index }}" 
                             class="panel-collapse collapse {{ $index === 0 ? 'in' : '' }}">
                            <div class="panel-body">
                                <h5>Description</h5>
                                <p>{!! $job->job_description !!}</p>
                                <h5>Job Location</h5>
                                <p>{{ $job->job_location }}</p>
                                <div class="careers-btn-box">
                                    <a href="#" 
                                       class="default-btn black-btn applyBtn"
                                       data-role="{{ $job->job_role }}"
                                       data-toggle="modal" 
                                       data-target="#applyModal">
                                       Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    

    <section class="careers-page-two-wrap" style="background-image: url('{{ asset('uploads/career/' . $careers->roles_icon) }}'); 
                background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat;">
        <div class="container">
            <div class="row">
              <div class="col-md-12">
                  <div class="careers-two-content-sec">
                        <h2>{{ $careers->role_heading }}</h2>
                        <p>{!! $careers->role_description !!}</p>
                  </div>
              </div>
              <div class="col-md-4">
              
              </div>
            </div>
        </div>
    </section>
    
    
    
    <!-- Modal -->
    <div id="applyModal" class="careers-modal-popup-wrap modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
        
              <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                <h4 class="modal-title">Apply Now</h4>
              </div>
        
                <div class="modal-body">
                    <form id="applyForm" action="{{ route('apply.job') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="text" id="positionApplied" name="positionApplied" class="form-control" readonly>
                            <small class="error-text text-danger"></small>
                        </div>
                    
                        <div class="row apply-now-modal-popup">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Full Name*">
                                    <small class="error-text text-danger"></small>
                                </div>
                            </div>
                    
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email Address*">
                                    <small class="error-text text-danger"></small>
                                </div>
                            </div>
                    
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number*">
                                    <small class="error-text text-danger"></small>
                                </div>
                            </div>
                    
                            <div class="col-sm-6">
                                <div class="form-group resumeUpload-wrap">
                                    <label for="resumeUpload" class="btn btn-default btn-block">
                                        Upload Resume*
                                        <input type="file" id="resumeUpload" name="resume" class="hidden" accept=".pdf,.doc,.docx">
                                    </label>
                                    <small class="text-muted">Only PDF, DOC, DOCX files are allowed. Max size 3MB.</small>
                                     <div class="selected-file text-success" style="margin-top:5px;"></div> <!-- Display file name -->
                                    <small class="error-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <textarea id="message" name="message" class="form-control" rows="3" placeholder="Message"></textarea>
                        </div>
                    
                        <div class="form-group checkbox-text">
                            <label>
                                <input type="checkbox" id="agreeCheck" name="agree" value="1">
                                By applying you agree L’azure may process your personal data to assess your suitability for employment. Applicant data handling is described in our 
                                <a href="{{ route('frontend.privacy_policy') }}" target="_blank">Privacy Policy</a>.
                            </label>
                            <small class="error-text text-danger"></small>
                        </div>
                        
                        <div class="col-md-12 form-group text-center">
                            <div style="display: inline-block;">
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            </div>
                            <div id="captchaError" class="error" style="color:red; margin-top: 5px;"></div>
                        </div>
                    
                        <div class="text-center">
                            <button type="submit" class="default-btn black-btn">Submit</button>
                        </div>
                    </form>
                </div>
        
            </div>
        </div>
    </div>



    @include('components.frontend.footer')

    @include('components.frontend.main-js')
    
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <!---- Form Validations---->
    <script>
    
        // Fill job role in dropdown automatically
        $(".applyBtn").click(function () {
            let role = $(this).data("role");
            $("#positionApplied").val(role);
        });
        
        $("#resumeUpload").on("change", function () {
            const file = this.files[0];
            const allowedExtensions = ["pdf", "doc", "docx"];
            const display = $(this).closest(".form-group").find(".selected-file");
        
            if (!file) {
                display.text("");
                return;
            }
        
            const fileExt = file.name.split('.').pop().toLowerCase();
            const fileSize = file.size / (1024 * 1024); // MB
        
            // Reset previous errors
            display.text("");
            $(this).closest(".form-group").find(".error-text").text("");
        
            if (!allowedExtensions.includes(fileExt)) {
                $(this).val(""); // Clear file
                display.text("");
                $(this).closest(".form-group").find(".error-text").text("Invalid file type. Only PDF, DOC, DOCX allowed.");
                return;
            }
        
            if (fileSize > 3) {
                $(this).val(""); // Clear file
                display.text("");
                $(this).closest(".form-group").find(".error-text").text("File too large! Max 3MB allowed.");
                return;
            }
        
            // ✅ Show file name
            display.text("File: " + file.name);
        });
                
        // Validation + submit
        $("#applyForm").on("submit", function (e) {
            e.preventDefault(); // block default
        
            let valid = true;
            $(".error-text").text("");
        
            const name = $("#fullName").val().trim();
            const email = $("#email").val().trim();
            const phone = $("#phone").val().trim();
            const role = $("#positionApplied").val();
            const resume = $("#resumeUpload")[0].files.length;
            const isAgree = $("#agreeCheck").is(":checked");
        
            const phoneRegex = /^[0-9]{10,15}$/;
        
            if (!role) {
                showError("#positionApplied", "Select position");
                valid = false;
            }
            if (name.length < 3) {
                showError("#fullName", "Enter valid name");
                valid = false;
            }
            if (!email.includes("@")) {
                showError("#email", "Enter valid email");
                valid = false;
            }
            if (!phoneRegex.test(phone)) {
                showError("#phone", "Phone must be 10–15 digits");
                valid = false;
            }
            if (!resume) {
                showError("#resumeUpload", "Upload resume");
                valid = false;
            }

            if (!isAgree) {
                $("#agreeCheck").closest(".form-group").find(".error-text").text("Please accept the terms");
                valid = false;
            }
            
            // ⭐ reCAPTCHA v2 validation ⭐
            let captcha = grecaptcha.getResponse();
            if (captcha.length === 0) {
                document.getElementById("captchaError").innerHTML = "Please verify that you are not a robot.";
                valid = false;
            }

            if (!valid) return;
            
            // ✅ Disable submit button & change text
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.prop('disabled', true).text("Submitting...");
        
            // ✅ Submit the form
            this.submit();

        });

        
        function showError(input, message) {
            $(input).closest(".form-group").find(".error-text").text(message);
        }


    </script>

</body>

</html>