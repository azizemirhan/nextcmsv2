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
<section class="relative overflow-hidden text-light">
    @if(!empty($content['background_image']))
    <div class="abs w-100 h-100 top-0 start-0 z-0" data-bgimage="url({{ Storage::url($content['background_image']) }}) center"></div>
    @endif
    <div class="abs w-100 h-100 top-0 start-0 z-1 bg-dark op-5"></div>
    <div class="container relative z-2">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                @if(!empty($content['video_url']))
                <a href="{{ $content['video_url'] }}" class="popup-youtube video-play-button">
                    <span></span>
                </a>
                @endif
                <div class="spacer-single"></div>
                <h3>{{ $content['title'] ?? '' }}</h3>
            </div>
        </div>
    </div>
</section>
