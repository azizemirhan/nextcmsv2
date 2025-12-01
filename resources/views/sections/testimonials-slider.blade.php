<section class="bg-color no-top no-bottom overflow-hidden">
    <div class="container-fluid relative half-fluid">
        <div class="container">
            <div class="row">
                <!-- Image -->
                <div class="col-lg-6 position-lg-absolute left-half h-100">
                    <div class="image wow fadeInLeft" data-bgimage="url({{ $content['background_image'] ?? asset('images/misc/s2.webp') }}) center"></div>
                </div>
                <!-- Text -->
                <div class="col-lg-5 offset-lg-7">
                    <div class="me-lg-3">
                        <div class="py-5 my-5">
                            <div class="owl-single-dots owl-carousel owl-theme">
                                @foreach($content['testimonials'] ?? [] as $testimonial)
                                    <div class="item">
                                        <i class="icofont-quote-left text-dark fs-40 d-block mb-4 wow fadeInUp"></i>
                                        <h3 class="mb-4 wow fadeInUp">
                                            {{ $testimonial['quote'] ?? '' }}
                                        </h3>
                                        <span class="wow fadeInUp">
                                            <strong>{{ $testimonial['author'] ?? '' }}</strong>
                                            @if(!empty($testimonial['position']))
                                                <br><span class="text-muted fs-14">{{ $testimonial['position'] }}</span>
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
