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
<section class="border-top">
    <div class="container">
        <div class="row gy-4 gx-5 align-items-center">
            <div class="col-lg-6">
                <div class="relative">
                    <div class="relative overflow-hidden z-2 mb-5 rounded-1 mb-4 w-60 soft-shadow wow zoomIn">
                        @if(!empty($content['image_1']))
                        <img src="{{ Storage::url($content['image_1']) }}" class="w-100 wow scaleIn" data-wow-duration="1s" alt="">
                        @endif
                    </div>

                    <div class="abs overflow-hidden top-0 end-0 mt-5 rounded-1 mb-4 w-60 wow zoomIn" data-wow-delay=".2s">
                        @if(!empty($content['image_2']))
                        <img src="{{ Storage::url($content['image_2']) }}" class="w-100 wow scaleIn" data-wow-duration="1s" alt="">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="subtitle id-color wow fadeInUp" data-wow-delay=".0s">{{ $content['subtitle'] ?? '' }}</div>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{!! $content['title'] ?? '' !!}</h2>
                <p class="wow fadeInUp" data-wow-delay=".4s">{{ $content['description'] ?? '' }}</p>

                <div class="border-bottom mb-4"></div>

                @if(!empty($content['features_list']))
                <ul class="ul-check fw-600 mb-4 wow fadeInUp" data-wow-delay=".6s">
                    @foreach($content['features_list'] as $feature)
                    <li>{{ $feature['text'] ?? '' }}</li>
                    @endforeach
                </ul>
                @endif

                @if(!empty($content['button_text']))
                <a class="btn-main fx-slide wow fadeInUp" data-wow-delay=".9s" href="{{ $content['button_url'] ?? '#' }}">
                    <span>{{ $content['button_text'] }}</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>
