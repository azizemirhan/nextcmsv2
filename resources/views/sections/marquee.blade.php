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

    $sectionClass = match($content['background_style'] ?? 'dark') {
        'light' => 'bg-light',
        'color' => 'bg-color',
        default => 'section-dark',
    };
    
    $innerClass = match($content['background_style'] ?? 'dark') {
        'dark' => 'bg-color text-dark',
        'light' => 'bg-white text-dark',
        'color' => 'bg-dark text-light',
        default => 'bg-color text-dark',
    };
@endphp

<section class="{{ $sectionClass }} p-0" aria-label="section">
    <div class="{{ $innerClass }} d-flex py-4 lh-1">
        <div class="de-marquee-list-2 wow fadeIn">
            @if(!empty($content['items']))
                @foreach($content['items'] as $item)
                    <span class="fs-40 fw-600 mx-3">{{ $item['text'] ?? '' }}</span>
                    @if(!empty($item['icon']))
                    <span class="fs-40 fw-600 mx-3"><img src="{{ Storage::url($item['icon']) }}" class="w-40px" alt=""></span>
                    @endif
                @endforeach
                 <!-- Duplicate for seamless loop if needed, usually JS handles it or CSS animation needs duplicate content -->
                 @foreach($content['items'] as $item)
                    <span class="fs-40 fw-600 mx-3">{{ $item['text'] ?? '' }}</span>
                    @if(!empty($item['icon']))
                    <span class="fs-40 fw-600 mx-3"><img src="{{ Storage::url($item['icon']) }}" class="w-40px" alt=""></span>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</section>
