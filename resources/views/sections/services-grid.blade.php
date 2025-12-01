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
<section class="bg-light">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="subtitle wow fadeInUp mb-3">{{ $content['subtitle'] ?? '' }}</div>
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{!! $content['title'] ?? '' !!}</h2>
                <p class="lead mb-0 wow fadeInUp">{{ $content['description'] ?? '' }}</p>
                <div class="spacer-single"></div>
                <div class="spacer-half"></div>
            </div>
        </div>

        <div class="row g-4">
            @if(!empty($content['services']))
                @foreach($content['services'] as $service)
                <div class="col-lg-4 col-sm-6">
                    <div class="hover">
                        <div class="relative overflow-hidden">
                            <a href="{{ $service['link'] ?? '#' }}" class="d-block hover">
                                <div class="relative overflow-hidden rounded-1">
                                    @if(!empty($service['image']))
                                    <img src="{{ Storage::url($service['image']) }}" class="w-100 hover-scale-1-2" alt="">
                                    @endif
                                </div>
                            </a>
                            <div class="p-30 relative bg-white rounded-1 mx-4 mt-min-100">
                                <div class="abs top-0 end-0 mt-min-30 me-4 circle bg-color w-60px h-60px">
                                    <a href="{{ $service['link'] ?? '#' }}">
                                        <img src="{{ asset('images/misc/up-right-arrow.webp') }}" class="w-60px p-20" alt="">
                                    </a>
                                </div>
                                <h4>{{ $service['title'] ?? '' }}</h4>
                                <p class="mb-0">{{ $service['description'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif

            @if(!empty($content['view_all_text']))
            <div class="text-center">
                <a class="btn-main fx-slide" href="{{ $content['view_all_url'] ?? '#' }}"><span>{{ $content['view_all_text'] }}</span></a>
            </div>
            @endif
        </div>
    </div>
</section>
