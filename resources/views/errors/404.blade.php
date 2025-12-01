@extends('frontend.layouts.app')

@section('content')
<section id="section-404" class="section-dark text-light relative overflow-hidden h-100vh d-flex align-items-center justify-content-center">
    <div class="container relative z-2">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="spacer-double"></div>
                <h1 class="fs-100 mb-0 wow scaleIn">404</h1>
                <h2 class="mb-4 wow fadeInUp">Page Not Found</h2>
                <p class="lead mb-5 wow fadeInUp" data-wow-delay=".2s">The page you are looking for does not exist or has been moved.</p>
                <a class="btn-main fx-slide wow fadeInUp" data-wow-delay=".4s" href="{{ route('home') }}">
                    <span>Back to Home</span>
                </a>
                <div class="spacer-double"></div>
            </div>
        </div>
    </div>
</section>
@endsection
