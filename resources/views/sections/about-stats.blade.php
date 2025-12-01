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
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h5 class="wow fadeInRight">{{ $content['badge'] ?? 'About Us' }}</h5>
            </div>
            <div class="col-lg-9">
                <h3 class="wow fadeInRight" data-wow-delay=".2s">
                    {!! $content['main_text'] ?? '' !!}
                </h3>

                <div class="spacer-single"></div>

                <div class="row g-4 gx-5">
                    @if(!empty($content['stats']))
                        @foreach($content['stats'] as $index => $stat)
                        <div class="col-md-3 col-sm-6">
                            <div class="de_count lh-1-6 wow fadeInRight" data-wow-delay=".{{ ($index + 1) * 2 }}s">
                                <h3 class="fs-40 mb-0">
                                    <span class="timer" data-to="{{ $stat['number'] ?? 0 }}" data-speed="3000">0</span>{{ $stat['suffix'] ?? '' }}
                                </h3>
                                {{ $stat['label'] ?? '' }}
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
