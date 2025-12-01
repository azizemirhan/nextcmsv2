<section id="subheader" class="bg-dark text-light relative jarallax"
    @if($page->banner_background_image)
        style="background-image: url({{ $page->banner_background_image }}); background-size: cover; background-repeat: no-repeat;"
    @elseif($page->banner_background_color)
        style="background-color: {{ $page->banner_background_color }};"
    @endif
    data-height="{{ match($page->banner_height ?? 'medium') { 'small' => '300px', 'medium' => '500px', 'large' => '700px', 'full' => '100vh', default => '500px' } }}">
    
    <div class="container relative z-2">
        <div class="row gy-4 gx-5 align-items-center">
            <div class="col-lg-12" style="text-align: {{ $page->banner_text_align ?? 'center' }};">
                <div class="spacer-double sm-hide"></div>
                
                @if($page->banner_subtitle)
                    <h5 class="wow fadeInUp" style="color: {{ $page->banner_text_color ?? 'white' }};">
                        {{ $page->getTranslation('banner_subtitle') }}
                    </h5>
                @endif
                
                @if($page->banner_title)
                    <h1 class="mb-3 wow fadeInUp" data-wow-delay=".2s" style="color: {{ $page->banner_text_color ?? 'white' }};">
                        {{ $page->getTranslation('banner_title') }}
                    </h1>
                @endif
                
                <div class="border-bottom mb-3"></div>
                
                {{-- Breadcrumb --}}
                <ul class="crumb wow fadeInUp">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">{{ $page->getTranslation('title') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="gradient-edge-bottom h-50"></div>
    <div class="sw-overlay" style="opacity: {{ $page->banner_overlay_opacity ?? '0.3' }};"></div>
</section>
