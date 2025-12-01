{{-- About & Stats Section --}}
<section>
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                @if(!empty($content['badge']))
                <div class="subtitle wow fadeInUp mb-3">{{ $content['badge'] }}</div>
                @endif
                @if(!empty($content['main_text']))
                <h2 class="wow fadeInUp" data-wow-delay=".2s">
                    {!! $content['main_text'] !!}
                </h2>
                @endif
            </div>

            @if(!empty($content['stats']))
            <div class="col-lg-7">
                <div class="row g-4">
                    @foreach($content['stats'] as $stat)
                    <div class="col-lg-4 col-sm-6">
                        <div class="de_count-item wow fadeInUp" data-wow-delay=".{{ $loop->index * 2 }}s">
                            <h2 class="mb-1">
                                <span class="de_count">{{ $stat['number'] ?? 0 }}</span>{{ $stat['suffix'] ?? '' }}
                            </h2>
                            <h5 class="fw-400">{{ $stat['label'] ?? '' }}</h5>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
