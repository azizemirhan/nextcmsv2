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
<section class="bg-dark text-light">
    <div class="container relative z-1">
        <div class="row g-4 gx-5 align-items-center">

            <div class="col-lg-6">
                <div class="relative">
                    <div class="bg-blur text-light text-center rounded-1 abs w-200px p-4 m-4 bottom-0 z-3 overflow-hidden wow zoomIn">
                        <h2 class="mb-0">{{ $content['stat_number'] ?? '' }}</h2>
                        <p class="lh-1-5">{{ $content['stat_text'] ?? '' }}</p>
                    </div>
                    <div class="rounded-1 w-90 overflow-hidden wow zoomIn">
                        @if(!empty($content['image_main']))
                        <img src="{{ Storage::url($content['image_main']) }}" class="w-100 wow scaleIn" alt="">
                        @endif
                    </div>
                    <div class="rounded-1 w-50 abs mb-min-50 end-0 bottom-0 z-2 overflow-hidden shadow-soft wow zoomIn" data-wow-delay=".2s">
                        @if(!empty($content['image_small']))
                        <img src="{{ Storage::url($content['image_small']) }}" class="w-100 wow scaleIn" data-wow-delay=".2s" alt="">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="subtitle id-color wow fadeInUp">{{ $content['subtitle'] ?? '' }}</div>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $content['title'] ?? '' }}</h2>
                
                <div class="row g-4">
                    @if(!empty($content['features']))
                        @foreach($content['features'] as $index => $feature)
                        <div class="col-lg-6">
                            <div class="h-100 rounded-1">
                                <div class="relative wow fadeInUp" data-wow-delay=".{{ $index * 2 }}s">
                                    <h4>{{ $feature['title'] ?? '' }}</h4>
                                    <p class="mb-0">{{ $feature['description'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
    <div class="spacer-double"></div>
</section>
