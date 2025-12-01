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
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="subtitle id-color wow fadeInUp" data-wow-delay=".0s">{{ $content['subtitle'] ?? '' }}</div>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $content['title'] ?? '' }}</h2>
            </div>
            <div class="col-lg-7">
                <div class="accordion" id="accordionExample">
                    @if(!empty($content['faqs']))
                        @foreach($content['faqs'] as $index => $faq)
                        <div class="accordion-item wow fadeInUp" data-wow-delay=".{{ $index + 2 }}s">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                    {{ $faq['question'] ?? '' }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {{ $faq['answer'] ?? '' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
