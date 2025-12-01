<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($page) ? ($page->getSeoTitle() ?? config('app.name')) : 'Page Not Found - ' . config('app.name') }}</title>
    
    <link rel="icon" href="{{ asset('assets/images/icon.webp') }}" type="image/gif" sizes="16x16">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/swiper.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/colors/scheme-1.css') }}" rel="stylesheet">
    
    {!! isset($page) ? $page->seoMeta?->renderMetaTags() : '' !!}
</head>
<body>
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>
        
        <!-- preloader begin -->
        <div id="de-loader"></div>
        <!-- preloader end -->

        @include('frontend.partials.header')
        
        @if(isset($page) && $page->banner_enabled)
            @include('frontend.partials.banner')
        @endif
        
        <div class="no-bottom no-top" id="content">
            @if(isset($page))
                @foreach($page->sections()->where('is_active', true)->orderBy('order')->get() as $section)
                    @if($section->isVisible())
                        {!! $section->render() !!}
                    @endif
                @endforeach
            @else
                @yield('content')
            @endif
        </div>
        
        @include('frontend.partials.footer')
    </div>
    
    <!-- overlay content begin -->
    <div id="extra-wrap" class="text-light">
        <div id="btn-close">
            <span></span>
            <span></span>
        </div>

        <div id="extra-content">
            <img src="{{ asset('assets/images/logo-white.webp') }}" class="w-150px" alt="">

            <div class="spacer-30-line"></div>

            <h5>Our Services</h5>
            <ul class="ul-check">
                <li>Solar Panel Installation</li>
                <li>Solar Panel Maintenance</li>
                <li>Custom System Design</li>
                <li>Solar Battery Storage</li>
                <li>System Monitoring & Reporting</li>
                <li>Solar Panel Upgrades</li>
            </ul>

            <div class="spacer-30-line"></div>

            <h5>Contact Us</h5>
            <div><i class="icofont-clock-time me-2 op-5"></i>Monday - Friday 08.00 - 18.00</div>
            <div><i class="icofont-location-pin me-2 op-5"></i>100 Solar Ave, San Diego, CA </div>
            <div><i class="icofont-envelope me-2 op-5"></i>support@solaria.com</div>

            <div class="spacer-30-line"></div>

            <h5>About Us</h5>
            <p>At Solaria, we’re committed to delivering reliable, efficient, and sustainable solar energy solutions.
                From residential installations to commercial systems, we help you harness the power of the sun and
                reduce your energy bills while protecting the planet.</p>

            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/designesia.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/custom-swiper-1.js') }}"></script>
    <script src="{{ asset('assets/js/custom-marquee.js') }}"></script>
</body>
</html>
