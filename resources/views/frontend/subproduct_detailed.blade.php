<!doctype html>
<html lang="en">
    
<head>
    
    
    @php
        $slug = last(request()->segments()); // gets last part of URL
        $subproduct = $subproducts->firstWhere('slug', $slug);
    @endphp
    
    @if($subproduct)
    
        <title>{{ $subproduct->meta_title ?? $product->sub_product }}</title>
    
        <meta name="description" content="{{ $subproduct->meta_description ?? 'Default description' }}">
    
        {!! $subproduct->cannonical !!}
        {!! $subproduct->hreflang !!}
        {!! $subproduct->og_tag !!}
        {!! $subproduct->twitter_card_tag !!}
    
    @endif
    
    @include('components.frontend.head')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightslider@1.1.6/dist/css/lightslider.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-freeze-table@1.3.0/dist/css/freeze-table.css">

</head>

    
    @include('components.frontend.header')


    <section class="breadcrumb-interior-spaces" style="background-image: url('{{ asset($subProductDetails->banner_image) }}'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">
        <div class="breadcrumb-text">
            <h1>{{ $product->sub_product }}</h1>
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
                <!--<li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">{{ $product1->product }}</a></li>-->
                <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">{{ $category->category }}</a></li>
                <li class="breadcrumb-page-name">{{ $product->sub_product }}</li>
            </ul>
        </div>

      </div>
    </section>

    <section class="product-details">
      <img class="anim-icons" src="{{ asset('frontend/assets/images/bg/pattern.svg') }}" alt="">
      <div class="container">
        <div class="row">
          <div class="col-md-7 col-sm-12 col-xs-12">
            <div class="lightSlider-card">
              <div class="demo">
                  <ul id="lightSlider">
                      @if(!empty($subProductDetails->gallery_images))
                          @php 
                              $galleryImages = json_decode($subProductDetails->gallery_images, true); 
                          @endphp

                          @foreach($galleryImages as $img)
                              <li data-thumb="{{ asset($img) }}">
                                  <img src="{{ asset($img) }}" alt="Gallery Image">
                              </li>
                          @endforeach
                      @endif
                  </ul>
              </div>

            </div>
          </div>
          <div class="col-md-5 col-sm-12 col-xs-12">
            <div class="description">
              <div class="heading">
                <h2>{{ $product->sub_product }}</h2>
              </div>
              <div class="sub-heading">
                <h6>{{ $application->application_type }}</h6>
              </div>
              <div class="description-two">
                <div class="short-desc ck-content">
                  <p>{!! $subProductDetails->sub_product_description !!}</p>
                </div>
              </div>
              <div class="enquire-now-btn">
                <a class="default-btn black-btn" data-toggle="modal" data-target="#team1">Enquire Now</a>
                <!--@if($showTryItOut)-->
                <!--    <a href="{{ route('applications.details', $product1->slug) }}"-->
                <!--       class="default-btn black-btn"-->
                <!--       target="_blank">-->
                <!--        Try it Out-->
                <!--    </a>-->
                <!--@endif-->


              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="services-section-two Description-datails">
      <img src="{{ asset('images/bg/pattern-2.svg') }}" class="anim-icons-two circleZoom">
      <div class="outer-box">
        <div class="container">
          <div class="row">
            <div class="heading heading-center heading-white">
              <h2 style="color: #ffffff">{{ $subProductDetails->sec_title }}</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <img src="{{ asset($subProductDetails->thumbnail_image) }}" 
                  alt="Product Image" 
                  class="img-fluid white-filter">
            </div>
            <div class="col-md-5">
              <div class="specs-table">
                @if(!empty($subProductDetails->specifications))
                  @php 
                    $specifications = json_decode($subProductDetails->specifications, true); 
                  @endphp
                  
                  @foreach($specifications as $spec)
                    <div class="spec-row">
                      <div class="spec-title">{{ $spec['specification'] ?? '' }}</div>
                      <div class="spec-value">{{ $spec['value'] ?? '' }}</div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <section class="accordion-main">
      <div class="container">
        <div class="row features-grid">
          @if(!empty($subProductDetails->features))
            @php
              $features = json_decode($subProductDetails->features, true);
            @endphp

            @foreach($features as $feature)
              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="feature-box">
                  <div class="icon">
                    <img src="{{ asset('frontend/assets/images/icons/check.svg') }}" 
                        class="img-responsive hvr-icon" 
                        alt="check icon">
                  </div>
                  <div class="content">
                    <div class="title">{{ $feature['heading'] ?? '' }}</div>
                    <div class="desc">{{ $feature['description'] ?? '' }}</div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </section>


    <section class="table-datails">
      <div class="container">
        <div class="heading heading-center col-md-12">
          <h2>Product Details</h2>
        </div>

        <div class="row">

      
          <!-- Filters Row -->
          <div class="col-lg-11 mb-4">
            <div class="row g-3 align-items-end" id="filters" data-subproduct="{{ $product->id }}">

              <!-- Size -->
              <div class="col-md-2">
                <label for="size"><strong>Size</strong></label>
                <select class="form-control" id="size" name="size">
                  <option value="">Select Size</option>
                  @foreach($modelDetails->pluck('size')->unique()->filter() as $size)
                    <option value="{{ $size }}">{{ $size }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Wattage -->
              <div class="col-md-2">
                <label for="wattage"><strong>Wattage</strong></label>
                <select class="form-control" id="wattage" name="wattage">
                  <option value="">Select Wattage</option>
                  @foreach($modelDetails->pluck('wattage')->unique()->filter() as $wattage)
                    <option value="{{ $wattage }}">{{ $wattage }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Lumens -->
              <div class="col-md-2">
                <label for="lumens"><strong>Lumens</strong></label>
                <select class="form-control" id="lumens" name="lumens">
                  <option value="">Select Lumens</option>
                  @foreach($modelDetails->pluck('lumens')->unique()->filter() as $lumens)
                    <option value="{{ $lumens }}">{{ $lumens }}</option>
                  @endforeach
                </select>
              </div>

              <!-- CCT -->
              <div class="col-md-2">
                <label for="cct"><strong>CCT</strong></label>
                <select class="form-control" id="cct" name="cct">
                  <option value="">Select CCT</option>
                  @foreach($modelDetails->pluck('cct')->unique()->filter() as $cct)
                    <option value="{{ $cct }}">{{ $cct }}</option>
                  @endforeach
                </select>
              </div>

              <!-- CRI -->
              <div class="col-md-2">
                <label for="cri"><strong>CRI</strong></label>
                <select class="form-control" id="cri" name="cri">
                  <option value="">Select</option>
                  @foreach($modelDetails->pluck('cri')->unique()->filter() as $cri)
                    <option value="{{ $cri }}">{{ $cri }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Beam Angle -->
              <div class="col-md-2">
                <label for="beam_angle"><strong>Beam Angle</strong></label>
                <select class="form-control" id="beam_angle" name="beam_angle">
                  <option value="">Select Beam Angle</option>
                  @foreach($modelDetails->pluck('beam_angle')->unique()->filter() as $beam)
                    <option value="{{ $beam }}">{{ $beam }}</option>
                  @endforeach
                </select>
              </div>
              
              
               

             

            </div>
          </div>
          
           <div class="col-lg-1 mb-4">
                <!-- Reset Filters Icon -->
              <div class="d-flex align-items-end product-reset-btn-wrap" style="margin-top: 24px !important;">
                <button type="button" id="resetFilters" class="btn btn-outline-secondary btn-sm" title="Reset Filters">
                  <i class="fa fa-undo"></i>
                </button>
              </div>
           </div>


          <div class="col-lg-12 col-md-12 mt-5 table-scroll-wrapper" style="margin-top: 30px;">
            <div class="product-detail-table table-responsive freeze-table table-basic">
              <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Model</th>
                    <th scope="col">Model Name</th>
                    <th scope="col">Model No</th>
                    <th scope="col">Size</th>
                    <th scope="col">Wattage</th>
                    <th scope="col">Lumens</th>
                    <th scope="col">CCT</th>
                    <th scope="col">CRI</th>
                    <th scope="col">Beam Angle</th>
                    <th scope="col">IP Rating</th>
                    <th scope="col">Accessories</th>
                    <th scope="col">Dimming Option</th>
                    <th scope="col">Specssheet</th>
                    <th scope="col">2D</th>
                    <th scope="col">3D</th>
                    <th scope="col">Installation Manual</th>
                  </tr>
                </thead>
                <tbody id="modelTableBody">
                    @foreach($modelDetails as $detail)
                        <tr>
                            <th scope="row">
                                <img src="{{ asset($detail->product_image) }}" alt="product-img" style="height:100px; width:100px">
                            </th>
                            <td>{{ $detail->model_name ?? '-' }}</td>
                            <td>{{ $detail->model_no ?? '-' }}</td>
                            <td>{{ $detail->size ?? '-' }}</td>
                            <td>{{ $detail->wattage ?? '-' }}</td>
                            <td>{{ $detail->lumens ?? '-' }}</td>
                            <td>{{ $detail->cct ?? '-' }}</td>
                            <td>{{ $detail->cri ?? '-' }}</td>
                            <td>{{ $detail->beam_angle ?? '-' }}</td>
                            <td>{{ $detail->ip_rating ?? '-' }}</td>
                            <td>{{ $detail->accessories ?? '-' }}</td>
                            <td>{{ $detail->dimming_options ?? '-' }}</td>
                            
                            {{-- Downloads (if you plan to store file paths for specsheet, 2D, 3D, manual) --}}
                            <td>
                                @if(!empty($detail->specssheet))
                                    <a href="{{ asset($detail->specssheet) }}" class="download-pdf" download>Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($detail->drawings_2d))
                                    <a href="{{ asset($detail->drawings_2d) }}" class="download-pdf" download>Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($detail->drawings_3d))
                                    <a href="{{ asset($detail->drawings_3d) }}" class="download-pdf" download>Download</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(!empty($detail->installation_manual))
                                    <a href="{{ asset($detail->installation_manual) }}" class="download-pdf" download>Download</a>
                                @else
                                    -
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="projects-wrap related-products">
        <div class="container">
            <div class="heading heading-center heading-white">
                <h2>Related Products</h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="related-product-carousel owl-theme owl-carousel">
                        @foreach($relatedProducts as $sub)
                            <div class="item">
                                <div class="product-item">
                                    <img src="{{ asset( $sub->thumbnail_image) }}" class="img-product-img" alt="{{ $sub->name }}">
                                    <div class="bottom-fade"></div>
                                    <div class="icon"> 
                                       <a href="{{ route('subproduct.detail', [
                                            $application->slug,
                                             $category->slug, 
                                            $sub->slug
                                        ]) }}" class="arrow">
                                            <img src="{{ asset('frontend/assets/images/icons/right-arrow-white.svg') }}">
                                        </a>


                                    </div>
                                    <div class="title">
                                        <h4>{{ $sub->sub_product }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- Modal -->
    <div class="modal fade" id="team1" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Enquire Now</h4>
          </div>
          <div class="modal-body">
            <div class="contact-form-box">
                <form id="contactForm" action="{{ route('send.product.inquiry') }}" method="post">
                    @csrf
                    
                    <input type="hidden" name="product_name" value="{{ $product1->product }}">
                    <input type="hidden" name="sub_product_name" value="{{ $product->sub_product }}">

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
                
                    <div class="form-group col-md-12">
                        <label>Feel free to ask a question or simply leave a comment.</label>
                        <textarea class="form-control" name="intro"></textarea>
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



    @include('components.frontend.footer')
    

    @include('components.frontend.main-js')

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('frontend/assets/js/lightslider.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/freeze-table.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        $(function(){
          $('.freeze-table').freezeTable({
           freezeHead: true,          // keep header sticky
            freezeColumn: true,        // freeze columns
            columnNum: 3,              // first 3 columns
            shadow: true,
            backgroundColor: '#fff',
            scrollable: true  
          });
        });
    </script>
    
    <script>
        $('#resetFilters').on('click', function () {
            $('#filters select').val('').trigger('change');
        });
    </script>

    <script>
      $(document).ready(function(){
          $('#filters select').on('change', function(){
              let changedFilter = this.id; // get which filter changed
              let subProductId = $('#filters').data('subproduct');

              let data = {
                  sub_product_id: subProductId,
                  size: $('#size').val(),
                  wattage: $('#wattage').val(),
                  lumens: $('#lumens').val(),
                  cct: $('#cct').val(),
                  cri: $('#cri').val(),
                  beam_angle: $('#beam_angle').val()
              };

              $.ajax({
                  url: "{{ route('filter.model.details') }}",
                  method: "GET",
                  data: data,
                  success: function(response){
                      // update all except the one just changed
                      if (changedFilter !== 'size')
                          updateOptions('#size', response.size, data.size);

                      if (changedFilter !== 'wattage')
                          updateOptions('#wattage', response.wattage, data.wattage);

                      if (changedFilter !== 'lumens')
                          updateOptions('#lumens', response.lumens, data.lumens);

                      if (changedFilter !== 'cct')
                          updateOptions('#cct', response.cct, data.cct);

                      if (changedFilter !== 'cri')
                          updateOptions('#cri', response.cri, data.cri);

                      if (changedFilter !== 'beam_angle')
                          updateOptions('#beam_angle', response.beam_angle, data.beam_angle);
                  }
              });
          });

          function updateOptions(selectId, values, selectedValue){
              let select = $(selectId);
              let currentVal = selectedValue || "";

              select.empty().append('<option value="">Select</option>');

              $.each(values, function(index, value){
                  let selected = (value === currentVal) ? 'selected' : '';
                  select.append('<option value="'+ value +'" '+selected+'>'+ value +'</option>');
              });
          }
      });
    </script>

    <script>
      $(document).ready(function() {
          $('#filters select').on('change', function() {
              let subProductId = $('#filters').data('subproduct');

              let data = {
                  sub_product_id: subProductId,
                  size: $('#size').val(),
                  wattage: $('#wattage').val(),
                  lumens: $('#lumens').val(),
                  cct: $('#cct').val(),
                  cri: $('#cri').val(),
                  beam_angle: $('#beam_angle').val()
              };

              $.ajax({
                  url: "{{ route('filter.model.details') }}", // your route
                  method: "GET",
                  data: data,
                  success: function(response) {
                      // Update dropdowns
                      updateOptions('#size', response.size, data.size);
                      updateOptions('#wattage', response.wattage, data.wattage);
                      updateOptions('#lumens', response.lumens, data.lumens);
                      updateOptions('#cct', response.cct, data.cct);
                      updateOptions('#cri', response.cri, data.cri);
                      updateOptions('#beam_angle', response.beam_angle, data.beam_angle);

                      // Update table rows
                      $('#modelTableBody').html(response.tableRows);

                      // Re-initialize freezeTable
                      $('.freeze-table').freezeTable('destroy'); // destroy previous instance
                      $('.freeze-table').freezeTable({
                          freezeHead: false,
                          freezeColumn: true,
                          columnNum: 3,
                          backgroundColor: 'white'
                      });
                  }

              });
          });

          function updateOptions(selectId, values, selectedValue) {
              let select = $(selectId);
              let currentVal = selectedValue || "";

              select.empty().append('<option value="">Select</option>');

              $.each(values, function(index, value) {
                  let selected = (value === currentVal) ? 'selected' : '';
                  select.append('<option value="'+ value +'" '+selected+'>'+ value +'</option>');
              });
          }
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
            const message = document.querySelector('textarea[name="intro"]');
        
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
        
            // Message optional but show warning if too short
            if (message.value.length > 0 && message.value.length < 1) {
                showError(message, "Message should be at least 5 characters");
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

</body>

</html>
