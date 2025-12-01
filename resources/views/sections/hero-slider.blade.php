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
<section id="section-intro" class="text-light relative overflow-hidden mh-700">
    <div class="relative z-4">
        <div class="container z-2">
            <div class="row g-4 align-items-center justify-content-center">
                <div class="col-lg-7 text-center">
                    <div class="spacer-double"></div>
                    <h1>{!! $content['main_headline'] ?? '' !!}</h1>
                    <p>{!! $content['description'] ?? '' !!}</p>
                    @if(!empty($content['button_text']))
                    <a class="btn-main fx-slide" href="{{ $content['button_url'] ?? '#' }}">
                        <span>{{ $content['button_text'] }}</span>
                    </a>
                    @endif
                </div>
            </div>

            <div class="spacer-double sm-hide"></div>
            <div class="spacer-double"></div>

            <div class="row g-4 justify-content-between">
                <div class="col-md-6">
                    <div class="p-4 bg-blur rounded-1 h-100">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-6">
                                @if(!empty($content['box1_image']))
                                <img src="{{ Storage::url($content['box1_image']) }}" class="w-100 rounded-1" alt="">
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <h3>{{ $content['box1_title'] ?? '' }}</h3>
                                <p>{{ $content['box1_desc'] ?? '' }}</p>
                                <a class="btn-main btn-line fx-slide" href="#"><span>View Services</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="p-4 h-100 bg-blur rounded-1">
                                <div>
                                    <div class="relative wow fadeInUp">
                                        <img src="{{ asset('images/icons-dark/1.png') }}" class="bg-color w-30 p-2 rounded-1 mb-3 wow scaleIn" alt="">
                                        <h4>{{ $content['box2_title'] ?? '' }}</h4>
                                        <p class="mb-0">{{ $content['box2_desc'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="bg-color text-dark rounded-1 h-100 w-100 p-4 py-5 z-3 overflow-hidden wow zoomIn">
                                <div class="text-end">
                                    <img src="{{ asset('images/icons-dark/solar-panel.png') }}" class="w-80px mb-3" alt="">
                                </div>
                                <h5 class="mb-0">{{ $content['box3_number'] ?? '' }}</h5>
                                <h2 class="mb-0 fs-32">{{ $content['box3_text'] ?? '' }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="swiper wow scaleIn">
        <div class="swiper-wrapper">
            @if(!empty($content['slider_images']))
                @foreach($content['slider_images'] as $slide)
                <div class="swiper-slide">
                    <div class="swiper-inner" data-bgimage="url({{ Storage::url($slide['image']) }}) center">
                        <div class="sw-overlay op-3"></div>
                        <div class="gradient-edge-top op-8"></div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Default Slide -->
                <div class="swiper-slide">
                    <div class="swiper-inner" data-bgimage="url({{ asset('images/slider/3.webp') }}) center">
                        <div class="sw-overlay op-3"></div>
                        <div class="gradient-edge-top op-8"></div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
