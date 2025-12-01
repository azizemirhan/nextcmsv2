<section class="border-top">
    <div class="container">
        <div class="row gy-4 gx-5 align-items-center">
            <div class="col-lg-6">
                <div class="relative">
                    @if(!empty($content['image_left']))
                        <div class="relative overflow-hidden z-2 mb-5 rounded-1 mb-4 w-60 soft-shadow wow zoomIn">
                            <img src="{{ $content['image_left'] }}" class="w-100 wow scaleIn" data-wow-duration="1s" alt="">
                        </div>
                    @endif

                    @if(!empty($content['image_right']))
                        <div class="abs overflow-hidden top-0 end-0 mt-5 rounded-1 mb-4 w-60 wow zoomIn" data-wow-delay=".2s">
                            <img src="{{ $content['image_right'] }}" class="w-100 wow scaleIn" data-wow-duration="1s" alt="">
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                @if(!empty($content['subtitle']))
                    <div class="subtitle id-color wow fadeInUp" data-wow-delay=".0s">{{ $content['subtitle'] }}</div>
                @endif
                
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $content['title'] ?? '' }}</h2>
                
                @if(!empty($content['description']))
                    <p class="wow fadeInUp" data-wow-delay=".4s">{{ $content['description'] }}</p>
                @endif

                <div class="border-bottom mb-4"></div>

                @if(!empty($content['checklist']))
                    <ul class="ul-check fw-600 mb-4 wow fadeInUp" data-wow-delay=".6s">
                        @foreach($content['checklist'] as $item)
                            <li>{{ $item['text'] ?? '' }}</li>
                        @endforeach
                    </ul>
                @endif

                @if(!empty($content['cta_text']))
                    <a class="btn-main fx-slide wow fadeInUp" data-wow-delay=".9s" href="{{ $content['cta_url'] ?? '#' }}">
                        <span>{{ $content['cta_text'] }}</span>
                    </a>
                @endif

            </div>
        </div>
    </div>
</section>
