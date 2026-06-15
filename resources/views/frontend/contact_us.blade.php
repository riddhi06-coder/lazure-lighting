<html lang="en">
    
<head>
    
     <title>Contact Lazure Lighting | Get in Touch With Us</title>
    
    <meta name="description" content="Get in touch with the Lazure Lighting team — contact us for product enquiries, custom lighting solutions, project specifications and partnerships across India and internationally.">
    
    
    @verbatim 
        <script type="application/ld+json">
            {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Lazure Lighting",
      "alternateName": "L'azure Lighting",
      "url": "https://lazurelighting.com",
      "logo": {
        "@type": "ImageObject",
        "url": "https://lazurelighting.com/frontend/assets/images/home/logo.webp"
      },
      "image": "https://lazurelighting.com/uploads/home/banner/1765264510314.webp",
      "description": "With over 50 years of experience in the lighting industry, Lazure Lighting is a trusted LED lighting manufacturer and luxury lighting solutions provider committed to quality, precision, and innovation. Having executed 1000+ projects across India and internationally, we specialize in bespoke, high-performance interior and exterior lighting solutions for architects, interior designers, and developers.",
      "foundingDate": "1974",
      "email": "info@lazurelighting.com",
      "telephone": "+91-9876543210",
      "address": [
        {
          "@type": "PostalAddress",
          "name": "L'azure India",
          "streetAddress": "Lotus Link Square, 1703, Near D.N Nagar Metro Station",
          "addressLocality": "Mumbai",
          "addressRegion": "Maharashtra",
          "postalCode": "400053",
          "addressCountry": "IN"
        },
        {
          "@type": "PostalAddress",
          "name": "L'azure UK",
          "streetAddress": "85, Great Portland Street",
          "addressLocality": "London",
          "addressRegion": "England",
          "postalCode": "W1W 7LT",
          "addressCountry": "GB"
        },
        {
          "@type": "PostalAddress",
          "name": "L'azure UAE",
          "streetAddress": "111, Al Fahad 3, Al Qusais",
          "addressLocality": "Dubai",
          "postalCode": "00000",
          "addressCountry": "AE"
        }
      ],
      "location": [
        {
          "@type": "Place",
          "name": "L'azure India",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Lotus Link Square, 1703, Near D.N Nagar Metro Station",
            "addressLocality": "Mumbai",
            "addressRegion": "Maharashtra",
            "postalCode": "400053",
            "addressCountry": "IN"
          }
        },
        {
          "@type": "Place",
          "name": "L'azure UK",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "85, Great Portland Street",
            "addressLocality": "London",
            "addressRegion": "England",
            "addressCountry": "GB"
          }
        },
        {
          "@type": "Place",
          "name": "L'azure UAE",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "111, Al Fahad 3, Al Qusais",
            "addressLocality": "Dubai",
            "addressCountry": "AE"
          }
        }
      ],
      "sameAs": [
        "https://www.instagram.com/lazurelighting/",
        "https://www.linkedin.com/company/lazurelighting/"
      ],
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+91-9876543210",
        "contactType": "customer service",
        "email": "info@lazurelighting.com",
        "availableLanguage": "English"
      },
      "knowsAbout": [
        "LED Lighting",
        "Luxury Lighting Solutions",
        "Architectural Lighting",
        "Interior Lighting",
        "Exterior Lighting",
        "Custom Lighting Solutions",
        "Lighting Design",
        "Lighting Manufacturing"
      ],
      "hasOfferCatalog": {
      "@type": "OfferCatalog",
      "name": "Lighting Products",
      "itemListElement": [
        {
          "@type": "OfferCatalog",
          "name": "Interior Spaces",
          "itemListElement": [
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Downlights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Integrated System Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Linear Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Pendant and Suspension Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Track Mounted Lights" } }
          ]
        },
        {
          "@type": "OfferCatalog",
          "name": "Exterior Spaces",
          "itemListElement": [
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Burial and Underwater Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Linear Grazer Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Pole and Bollard Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Facade Projector Lights" } },
            { "@type": "Offer", "itemOffered": { "@type": "Service", "name": "Wall Lights" } }
          ]
        }
      ]
    },
      "areaServed": [
        { "@type": "Country", "name": "India" },
        { "@type": "Country", "name": "United Kingdom" },
        { "@type": "Country", "name": "United Arab Emirates" },
        { "@type": "AdministrativeArea", "name": "International" }
      ],
      "award": "Lux Futurum Award — for a light-based prototype helping surgeons identify malignant tumours"
    }
        </script>
    @endverbatim
    
    @include('components.frontend.head')
    
    <style>
        .error {
            color: red;
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }
    </style>
    
</head>

    
    @include('components.frontend.header')
    
    
    <section class="breadcrumb-interior-spaces about-breadcrumb">
      <div class="breadcrumb-text">
        <h1>Contact Us</h1>
      </div>
      <div class="breadcrumb">
        <ul>
          <li><a href="{{ route('frontend.index') }}">Home</a></li>
          <li class="breadcrumb-page-name"><a href="#" class="second-breadcrumb">Contact Us</a></li>
          <!--<li class="breadcrumb-page-name">About Lazure Lighting</li>-->
        </ul>
      </div>
    </section>
    
    
     @php
        // Get the first (and only) contact record
        $contact = $contact_us->first();
        $locations = json_decode($contact->locations, true); // Decode JSON to array
    @endphp
    
    {{-- Head Office --}}
    <section class="contact-location-wrap">
        <div class="container">
            <div class="row">
                {{-- Head Office Image --}}
                <div class="col-md-6 cont-location-img">
                    <div class="solution-img"> 
                        <img  src="{{ !empty($contact->image_one)
                                ? asset('uploads/contact/'.$contact->image_one)
                                : asset('frontend/assets/images/home/head-office-sec-img.webp') }}" class="img-responsive solution-img-img" alt="Head Office Image">
                        <div class="bottom-fade"></div>
                        <div class="icon"> 
                            <a class="vid arrow">
                                <img src="{{ asset('frontend/assets/images/icons/building.svg') }}">
                            </a>
                        </div>
                    </div>
                </div>
    
                {{-- Head Office Details --}}
                <div class="col-md-6">
                    <div class="contact-location-india-sec">
                        @php
                            $headOffice = collect($locations)->first(); // assuming first entry is head office
                        @endphp
                        <h4>Head Office - {{ explode(' ', $headOffice['name'])[1] }}</h4>
    
                        <div class="contact-us-iconcont-wrap">
                            <div class="cont-india-img-sec">
                                <img src="{{ asset('frontend/assets/images/icons/location-icon-img.webp') }}" alt="Location Icon">
                            </div>
                            <h6>
                                <a href="{{ $headOffice['gmap_url'] }}" target="_blank">
                                    {{ $headOffice['name'] }}, {{ $headOffice['address'] }}
                                </a>
                            </h6>
                        </div>
    
                        <div class="contact-us-iconcont-wrap">
                            <div class="cont-india-img-sec">
                                <img src="{{ asset('frontend/assets/images/icons/email-icon-img.webp') }}" alt="Email Icon">
                            </div>
                            <h6><a href="mailto:info@lazurelighting.com">{{  $contact_us->email }}</a></h6>
                        </div>
    
                        <!--<div class="contact-us-iconcont-wrap">-->
                        <!--    <div class="cont-india-img-sec">-->
                        <!--        <img src="{{ asset('frontend/assets/images/icons/phone-icon-img.webp') }}" alt="Phone Icon">-->
                        <!--    </div>-->
                        <!--    <h6><a href="tel:+919876543210">{{  $contact_us->contact_number }}</a></h6>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Branch Offices --}}
    <section class="contact-us-other-branch-sec">
        <div class="container">
            <div class="row">
                {{-- Branch Details --}}
                <div class="col-md-6">
                    <div class="inner-col-location">
                        <div class="row">
                            @foreach($locations as $index => $branch)
                                @if($index != 0) {{-- skip head office --}}
                                    <div class="col-md-12">
                                        <div class="contact-location-content-sec">
                                            <h4>Branch Office - {{ explode(' ', $branch['name'])[1] }}</h4>
                                            <div class="contact-us-icon-para-wrap">
                                                <img src="{{ asset('frontend/assets/images/icons/location-icon-img.webp') }}" alt="Location Icon">
                                                <h6>
                                                    <a href="{{ $branch['gmap_url'] }}" target="_blank">
                                                        {{ $branch['name'] }}, {{ $branch['address'] }}
                                                    </a>
                                                </h6>
                                            </div><br>
    
                                            <div class="contact-us-icon-para-wrap contact-us-icon-mail-sec">
                                                <img src="{{ asset('frontend/assets/images/icons/email-icon-img.webp') }}" alt="Email Icon">
                                                <h6><a href="mailto:info@lazurelighting.com">{{  $contact_us->email }}</a></h6>
                                            </div>
    
                                            <!--<div class="contact-us-icon-para-wrap contact-us-icon-phone-sec">-->
                                            <!--    <img src="{{ asset('frontend/assets/images/icons/phone-icon-img.webp') }}" alt="Phone Icon">-->
                                            <!--    <h6><a href="tel:+919876543210">{{  $contact_us->contact_number }}</a></h6>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
    
                {{-- Branch Image --}}
                <div class="col-md-6 contact-other-branch-sec">
                    <div class="solution-img"> 
                        <img  src="{{ !empty($contact->image_two)
                                    ? asset('uploads/contact/'.$contact->image_two)
                                    : asset('frontend/assets/images/home/other-branch-img-sec.webp') }}" class="img-responsive solution-img-img" alt="Branch Office Image">
                        <div class="bottom-fade"></div>
                        <div class="icon"> 
                            <a class="vid arrow">
                                <img src="{{ asset('frontend/assets/images/icons/building.svg') }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="contact-us-form-map-sec">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-us-form-col-sec">
                        <h3 class="contact-us-title">Get In Touch</h3>
                        <form method="post" id="contactForm" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <input name="name" type="text" placeholder="Your Name *">
                                    <span class="error" id="nameError"></span>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input name="phone" type="tel" placeholder="Your Phone *">
                                    <span class="error" id="phoneError"></span>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input name="email" type="email" placeholder="Your Email *">
                                    <span class="error" id="emailError"></span>
                                </div>
                                <div class="col-md-12 form-group">
                                    <input name="subject" type="text" placeholder="Subject *">
                                    <span class="error" id="subjectError"></span>
                                </div>
                                <div class="col-md-12 form-group">
                                    <textarea name="message" cols="30" rows="4" placeholder="Message *"></textarea>
                                    <span class="error" id="messageError"></span>
                                </div>
                                
                                <div class="col-md-12 form-group text-center">
                                    <div style="display: inline-block;">
                                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                    </div>
                                    <div id="captchaError" class="error" style="color:red; margin-top: 5px;"></div>
                                </div>

                                
                                <div class="col-md-12">
                                    <input class="default-btn contact-form-btn" name="submit" id="contactSubmitBtn" type="submit" value="Send Message">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-us-form-img-sec">
                        <img  src="{{ !empty($contact->image_three)
                                ? asset('uploads/contact/'.$contact->image_three)
                                : asset('frontend/assets/images/home/contact-us-side-img.webp') }}"  alt=" Contact Us">
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="contact-us-map-sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-us-inner-map-sec google-map map">
                       
                        <iframe class="contact-map-inner-wrap" src="{!! $contact_us->iframe_url !!}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
    @include('components.frontend.footer')

    @include('components.frontend.main-js')
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    
    <script>
        document.getElementById("contactForm").addEventListener("submit", function (event) {
            let valid = true;
    
            // Clear old errors
            document.querySelectorAll(".error").forEach(el => el.innerHTML = "");
    
            let name = document.querySelector("[name='name']").value.trim();
            let phone = document.querySelector("[name='phone']").value.trim();
            let email = document.querySelector("[name='email']").value.trim();
            let subject = document.querySelector("[name='subject']").value.trim();
            let message = document.querySelector("[name='message']").value.trim();
            let submitBtn = document.querySelector("#contactSubmitBtn");
    
            // Name validation
            let nameRegex = /^[A-Za-z\s]+$/;
            if (!nameRegex.test(name)) {
                document.getElementById("nameError").innerHTML = "Name must contain only letters.";
                valid = false;
            }
    
            // Phone validation
            let phoneRegex = /^[0-9]{10,15}$/;
            if (!phoneRegex.test(phone)) {
                document.getElementById("phoneError").innerHTML = "Phone must be 10 to 15 digits.";
                valid = false;
            }
    
            // Email validation
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById("emailError").innerHTML = "Enter a valid email.";
                valid = false;
            }
    
            if (!subject) {
                document.getElementById("subjectError").innerHTML = "Subject is required.";
                valid = false;
            }
    
            if (!message) {
                document.getElementById("messageError").innerHTML = "Message is required.";
                valid = false;
            }
            
            // ⭐ reCAPTCHA v2 validation ⭐
            let captcha = grecaptcha.getResponse();
            if (captcha.length === 0) {
                document.getElementById("captchaError").innerHTML = "Please verify that you are not a robot.";
                valid = false;
            }

    
            if (!valid) {
                event.preventDefault();
            } else {
                // Disable button & show submitting state
                submitBtn.disabled = true;
                submitBtn.value = "Submitting...";
            }
        });
    </script>



</body>

</html>