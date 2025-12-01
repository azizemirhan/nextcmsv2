{{-- Services Grid Section --}}
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                @if(!empty($content['subtitle']))
                <div class="subtitle wow fadeInUp mb-3">{{ $content['subtitle'] }}</div>
                @endif
                @if(!empty($content['title']))
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $content['title'] }}</h2>
                @endif
                @if(!empty($content['description']))
                <p class="lead wow fadeInUp" data-wow-delay=".4s">{{ $content['description'] }}</p>
                @endif
            </div>
        </div>

        @if(!empty($content['services']))
        <div class="spacer-single"></div>
        <div class="row g-4">
            @foreach($content['services'] as $service)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $loop->index * 2 }}s">
                <div class="de-card h-100">
                    @if(!empty($service['image']))
                    <div class="d-image">
                        <img src="{{ asset('storage/' . $service['image']) }}" class="img-fluid rounded-top" alt="{{ $service['title'] ?? '' }}">
                    </div>
                    @endif
                    <div class="d-content p-4">
                        @if(!empty($service['title']))
                        <h4 class="mb-3">{{ $service['title'] }}</h4>
                        @endif
                        @if(!empty($service['description']))
                        <p>{{ $service['description'] }}</p>
                        @endif
                        @if(!empty($service['link']))
                        <a href="{{ $service['link'] }}" class="d-arrow-link">
                            <span>{{ __('Learn More') }}</span>
                            <i class="arrow_right"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if(!empty($content['view_all_text']) && !empty($content['view_all_url']))
        <div class="spacer-single"></div>
        <div class="text-center">
            <a class="btn-main" href="{{ $content['view_all_url'] }}">
                <span>{{ $content['view_all_text'] }}</span>
            </a>
        </div>
        @endif
    </div>
</section>
