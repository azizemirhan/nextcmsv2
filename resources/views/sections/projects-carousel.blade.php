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
            <div class="col-lg-12 wow fadeInUp">
                <div class="overflow-hidden rounded-1">
                    <div class="relative wow fadeIn">
                        <div class="owl-custom-nav menu-float" data-target="#project-single-carousel">
                            <a class="btn-next"></a>
                            <a class="btn-prev"></a>

                            <div id="project-single-carousel" class="owl-3-cols owl-carousel owl-theme">
                                @if(!empty($content['projects']))
                                    @foreach($content['projects'] as $project)
                                    <div class="item">
                                        <a href="{{ $project['link'] ?? '#' }}">
                                            <div class="hover rounded-1 relative overflow-hidden text-light">
                                                <div class="abs p-40 top-0 z-3">
                                                    <img src="{{ asset('images/misc/up-right-arrow-white.webp') }}" class="w-10 mb-3 wow scaleIn" alt="">
                                                </div>
                                                <div class="abs p-40 bottom-0 z-3">
                                                    <h3>{{ is_array($project['title'] ?? '') ? ($project['title'][app()->getLocale()] ?? $project['title']['en'] ?? reset($project['title']) ?? '') : ($project['title'] ?? '') }}</h3>
                                                    <p class="mb-0 hover-mh-60">{{ is_array($project['category'] ?? '') ? ($project['category'][app()->getLocale()] ?? $project['category']['en'] ?? reset($project['category']) ?? '') : ($project['category'] ?? '') }}</p>
                                                </div>
                                                <div class="hover-op-05 bg-dark abs w-100 h-100 top-0 start-0 z-2"></div>
                                                @if(!empty($project['image']))
                                                <img src="{{ Storage::url($project['image']) }}" class="w-100 hover-scale-1-2" alt="">
                                                @endif
                                                <div class="gradient-edge-bottom h-50"></div>
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
