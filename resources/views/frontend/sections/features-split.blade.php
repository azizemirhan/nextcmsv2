{{-- Features Split Section --}}
<section class="bg-grey">
    <div class="container">
        <div class="row g-4 align-items-center">
            {{-- Images Side --}}
            <div class="col-lg-6">
                <div class="relative wow fadeInLeft">
                    @if(!empty($content['image_1']))
                    <img src="{{ asset('storage/' . $content['image_1']) }}" class="img-fluid rounded-10 relative z-2" alt="">
                    @endif
                    @if(!empty($content['image_2']))
                    <img src="{{ asset('storage/' . $content['image_2']) }}" class="img-fluid rounded-10 abs abs-end" style="width: 50%; bottom: -30px; right: -30px;" alt="">
                    @endif
                </div>
            </div>

            {{-- Content Side --}}
            <div class="col-lg-6 wow fadeInRight">
                @if(!empty($content['subtitle']))
                <div class="subtitle mb-3">{{ $content['subtitle'] }}</div>
                @endif
                @if(!empty($content['title']))
                <h2 class="mb-3">{{ $content['title'] }}</h2>
                @endif
                @if(!empty($content['description']))
                <p class="mb-4">{{ $content['description'] }}</p>
                @endif

                @if(!empty($content['features_list']))
                <ul class="ul-check mb-4">
                    @foreach($content['features_list'] as $feature)
                        @if(!empty($feature['text']))
                        <li>{{ $feature['text'] }}</li>
                        @endif
                    @endforeach
                </ul>
                @endif

                @if(!empty($content['button_text']) && !empty($content['button_url']))
                <a class="btn-main" href="{{ $content['button_url'] }}">
                    <span>{{ $content['button_text'] }}</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
