@php
    $locale = app()->getLocale();
    
    $localize = function ($data) use ($locale, &$localize) {
        if (!is_array($data)) return $data;
        
        if (isset($data['en']) || isset($data['tr'])) {
            return $data[$locale] ?? $data['en'] ?? '';
        }

        return array_map($localize, $data);
    };

    $content = $localize($content);
@endphp
<section class="bg-color no-top no-bottom overflow-hidden">
    <div class="container-fluid relative half-fluid">
        <div class="container">
            <div class="row">
                <!-- Image -->
                <div class="col-lg-6 position-lg-absolute left-half h-100">
                    @if(!empty($content['image']))
                    <div class="image wow fadeInLeft" data-bgimage="url({{ Storage::url($content['image']) }}) center"></div>
                    @else
                    <div class="image wow fadeInLeft" data-bgimage="url({{ asset('images/misc/s2.webp') }}) center"></div>
                    @endif
                </div>
                <!-- Text -->
                <div class="col-lg-5 offset-lg-7">
                    <div class="me-lg-3">
                        <div class="py-5 my-5">
                            <div class="owl-single-dots owl-carousel owl-theme">
                                @if(!empty($content['testimonials']))
                                    @foreach($content['testimonials'] as $testimonial)
                                    <div class="item">
                                        <i class="icofont-quote-left text-dark fs-40 d-block mb-4 wow fadeInUp"></i>
                                        <h3 class="mb-4 wow fadeInUp">
                                            {{ $testimonial['quote'] ?? '' }}
                                        </h3>
                                        <span class="wow fadeInUp">{{ $testimonial['author'] ?? '' }}</span>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
