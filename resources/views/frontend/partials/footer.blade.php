<footer class="section-dark">
    <div class="container relative z-2">
        <div class="row gx-5">
            <div class="col-lg-4 col-sm-6">
                <img src="{{ asset('assets/images/logo-white.webp') }}" class="logo-footer" alt="">
                <div class="spacer-20"></div>
                <p>At Solaria, we’re committed to delivering reliable, efficient, and sustainable solar energy
                    solutions. From residential installations to commercial systems, we help you harness the
                    power of the sun and reduce your energy bills while protecting the planet.</p>

                <div class="social-icons mb-sm-30">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <div class="col-lg-5 col-sm-12 order-lg-1 order-sm-2">
                <div class="row">
                    <div class="col-lg-7 col-sm-6">
                        <div class="widget">
                            <h5>Our Services</h5>
                            <ul>
                                <li><a href="service-single.html">Solar Panel Installation</a></li>
                                <li><a href="service-single.html">Solar Panel Maintenance</a></li>
                                <li><a href="service-single.html">Custom System Design</a></li>
                                <li><a href="service-single.html">Solar Battery Storage</a></li>
                                <li><a href="service-single.html">System Monitoring & Reporting</a></li>
                                <li><a href="service-single.html">Solar Panel Upgrades</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5 col-sm-6">
                        <div class="widget">
                            <h5>Company</h5>
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="services.html">Our Services</a></li>
                                <li><a href="projects.html">Projects</a></li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 order-lg-2 order-sm-1">
                <div class="widget">
                    <h5>Contact Us</h5>

                    <div class="fw-bold text-white d-flex align-items-center">
                        <i class="icofont-location-pin me-2 id-color"></i><span>Head Office</span>
                    </div>
                    100 Solar Ave, San Diego, CA

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-white d-flex align-items-center">
                        <i class="icofont-phone me-2 id-color"></i><span>Call Us</span>
                    </div>
                    +1 800 987 654

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-white d-flex align-items-center">
                        <i class="icofont-envelope me-2 id-color"></i><span>Email Us</span>
                    </div>
                    support@solaria.com
                </div>
            </div>
        </div>
    </div>

    <div class="subfooter">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="de-flex">
                        <div class="de-flex-col">
                            &copy; {{ date('Y') }} - Solaria by Designesia
                        </div>
                        <ul class="menu-simple">
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="abs w-50 end-0 bottom-0 op-3">
        <img src="{{ asset('assets/images/misc/c1.webp') }}" class="w-100 rtl-hide wow fadeInRight" data-wow-duration="2s" alt="">
        <img src="{{ asset('assets/images/misc/c1-flip.webp') }}" class="w-100 rtl-show wow fadeInLeft" data-wow-duration="2s" alt="">
    </div>
</footer>
