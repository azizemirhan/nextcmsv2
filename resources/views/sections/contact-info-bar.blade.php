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
<section class="p-3 bg-dark text-light sm-hide">
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            @if(!empty($content['items']))
                @foreach($content['items'] as $item)
                <div class="d-flex align-items-center mx-4">
                    <i class="{{ $item['icon'] ?? 'icofont-info' }} me-2 fs-20 id-color"></i>
                    <div class="lh-1">
                        <span class="d-block fw-bold fs-14">{{ $item['title'] ?? '' }}</span>
                        <span class="op-7 fs-12">{{ $item['subtitle'] ?? '' }}</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
