{{-- Hero Slider Section --}}
<section id="section-hero" class="full-height vertical-center position-relative overflow-hidden">
    {{-- Background Slider --}}
    @if(!empty($content['slider_images']))
    <div class="swiper main-slider full-height">
        <div class="swiper-wrapper">
            @foreach($content['slider_images'] as $slide)
                @if(!empty($slide['image']))
                <div class="swiper-slide">
                    <div class="bg-image h-100" style="background-image: url('{{ asset('storage/' . $slide['image']) }}');"></div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <div class="v-center position-relative z-2">
        <div class="container">
            <div class="row align-items-center">
                {{-- Left Content --}}
                <div class="col-lg-6">
                    <div class="spacer-double d-lg-none d-sm-block"></div>
                    @if(!empty($content['main_headline']))
                    <h1 class="mb-3 wow fadeInUp" data-wow-delay=".6s">
                        {!! nl2br(e($content['main_headline'])) !!}
                    </h1>
                    @endif

                    @if(!empty($content['description']))
                    <p class="lead mb-4 wow fadeInUp" data-wow-delay=".7s">
                        {{ $content['description'] }}
                    </p>
                    @endif

                    @if(!empty($content['button_text']) && !empty($content['button_url']))
                    <a class="btn-main mb10 mb-3 wow fadeInUp" data-wow-delay=".8s" href="{{ $content['button_url'] }}">
                        <span>{{ $content['button_text'] }}</span>
                    </a>
                    @endif
                    <div class="spacer-single"></div>
                </div>

                {{-- Right Grid Content --}}
                <div class="col-lg-6">
                    <div class="row g-4">
                        {{-- Box 1 --}}
                        @if(!empty($content['box1_title']))
                        <div class="col-lg-6 col-sm-6 wow fadeIn" data-wow-delay="0s">
                            <div class="relative bg-blur rounded-20 p-4 h-100">
                                @if(!empty($content['box1_image']))
                                <img src="{{ asset('storage/' . $content['box1_image']) }}" class="w-100 mb-3 rounded-10" alt="{{ $content['box1_title'] }}">
                                @endif
                                <h5 class="mb-2">{{ $content['box1_title'] }}</h5>
                                @if(!empty($content['box1_desc']))
                                <p class="mb-0">{{ $content['box1_desc'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Box 2 --}}
                        @if(!empty($content['box2_title']))
                        <div class="col-lg-6 col-sm-6 wow fadeIn" data-wow-delay=".2s">
                            <div class="relative bg-blur rounded-20 p-4 h-100">
                                <h5 class="mb-2">{{ $content['box2_title'] }}</h5>
                                @if(!empty($content['box2_desc']))
                                <p class="mb-0">{{ $content['box2_desc'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Box 3 - Stats --}}
                        @if(!empty($content['box3_number']))
                        <div class="col-lg-12 wow fadeIn" data-wow-delay=".4s">
                            <div class="relative bg-blur rounded-20 p-4">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="de_count fs-60 fw-600">{{ $content['box3_number'] }}</div>
                                    </div>
                                    <div class="col-6">
                                        @if(!empty($content['box3_text']))
                                        <h5 class="mb-0">{{ $content['box3_text'] }}</h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
