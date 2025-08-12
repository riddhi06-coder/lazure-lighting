@php
    use App\Models\Contact;

    // Fetch the latest contact record
    $contact = Contact::wherenull('deleted_by')->first();
    $locations = $contact ? json_decode($contact->locations, true) : [];
    $socialMedia = $contact ? json_decode($contact->social_media, true) : [];
@endphp

<footer class="bg-dark text-light">
    <img class="anim-icons-three" src="{{ asset('frontend/assets/images/bg/pattern-3.svg') }}" alt="">
    <div class="container">
        <div class="f-items">
            <div class="row">
                {{-- About Section --}}
                <div class="col-lg-4 col-md-6 footer-item">
                    <div class="f-item about">
                        <img class="logo img-responsive" src="{{ asset('frontend/assets/images/home/logo.png') }}" alt="Logo">
                        <p>{!! $contact->about ?? '' !!}</p>
                    </div>
                    <ul class="footer-social">
                        @foreach($socialMedia as $sm)
                            @php
                                $url = strtolower($sm['link']);
                                if (str_contains($url, 'facebook')) {
                                    $icon = 'facebook-f';
                                } elseif (str_contains($url, 'twitter') || str_contains($url, 'x.com')) {
                                    $icon = 'twitter';
                                } elseif (str_contains($url, 'linkedin')) {
                                    $icon = 'linkedin';
                                } elseif (str_contains($url, 'instagram')) {
                                    $icon = 'instagram';
                                } elseif (str_contains($url, 'youtube')) {
                                    $icon = 'youtube';
                                } else {
                                    $icon = 'globe'; // fallback
                                }
                            @endphp
                            <li>
                                <a href="{{ $sm['link'] }}" target="_blank">
                                    <i class="fa fa-{{ $icon }}"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                </div>

                {{-- Quick Links Section --}}
                <div class="col-lg-3 col-md-6 footer-item">
                    <div class="f-item link">
                        <h4 class="widget-title">Quick Links</h4>
                        <ul class="foot">
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Articles</a></li>
                            <li><a href="#">FAQ's</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                            <li><a href="#">Site Map</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Contact Us Section --}}
                <div class="col-lg-5 col-md-6 footer-item">
                    <h4 class="widget-title">Contact Us</h4>
                    <ul class="opening-hours">
                        @if($contact)
                            <li>
                                <a href="mailto:{{ $contact->email }}">
                                    <div class="fot-box">
                                        <img src="{{ asset('frontend/assets/images/icons/email.png') }}"/>  
                                        <span>{{ $contact->email }}</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="tel:{{ $contact->contact_number }}">
                                    <div class="fot-box">
                                        <img src="{{ asset('frontend/assets/images/icons/phone.png') }}"/>  
                                        <span>+91 {{ $contact->contact_number }}</span>
                                    </div>
                                </a>
                            </li>
                            @if(!empty($locations))
                                <li>
                                    <div class="fot-box">
                                        <img src="{{ asset('frontend/assets/images/icons/location.png') }}"/> 
                                        <div class="fot-block">
                                            @foreach($locations as $loc)
                                                <p><b>{{ $loc['name'] }}</b>
                                                <span>
                                                    <a href="{{ $loc['gmap_url'] ?? '#' }}" 
                                                      target="_blank" style="margin:0;">
                                                        {{ $loc['address'] }}
                                                    </a>
                                                </span>
                                              </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <p>Copyright © {{ date('Y') }} Lazure Lighting. All rights reserved. Designed By  
                        <a target="_blank" href="https://www.matrixbricks.com/">Matrix Bricks</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
