@php
   $setting = App\Models\SiteSetting::find(1);
@endphp


<footer class="main-footer">
    <div class="footer-top bg-color-2">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-12 footer-column">
                    <div class="footer-widget about-widget">
                        <div class="widget-title">
                            <h3>About</h3>
                        </div>
                        <div class="text">
                            <p>RentHub revolutionizes home rentals through its Location-based Home Rental Management System, catering to both tenants and property owners. </p>
                            <p>RentHub transforms the home rental landscape, offering a user-friendly and easy experience.</p>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 footer-column">
                    <div class="footer-widget links-widget ml-70">
                        <div class="widget-title">
                            <h3>Services</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="links-list class">
                                <li><a href="index.html">About Us</a></li>
                                <li><a href="index.html">Listing</a></li>
                                <li><a href="index.html">Add Listing</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 col-sm-12 footer-column">
                    <div class="footer-widget contact-widget">
                        <div class="widget-title">
                            <h3>Contacts</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="info-list clearfix">
                                <li><i class="fas fa-map-marker-alt"></i>{{ $setting->company_address }}</li>
                                <li><i class="fas fa-microphone"></i><a href="tel:23055873407">{{ $setting->support_phone }}</a></li>
                                <li><i class="fas fa-envelope"></i><a href="mailto:info@example.com">{{ $setting->email }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="auto-container">
            <div class="inner-box clearfix">
                <!-- <figure class="footer-logo"><a href="index.html"><img src="{{ asset('frontend/assets/images/footer-logo.png') }}" alt=""></a></figure> -->
                <div class="copyright pull-left">
                    <p><a href="index.html">{{ $setting->copyright }}</p>
                </div>
                <!-- <ul class="footer-nav pull-right clearfix">
                    <li><a href="index.html">Terms of Service</a></li>
                    <li><a href="index.html">Privacy Policy</a></li>
                </ul> -->
            </div>
        </div>
    </div>
</footer>