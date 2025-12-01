{{-- FAQ Accordion Section --}}
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                @if(!empty($content['subtitle']))
                <div class="subtitle wow fadeInUp mb-3">{{ $content['subtitle'] }}</div>
                @endif
                @if(!empty($content['title']))
                <h2 class="wow fadeInUp" data-wow-delay=".2s">{{ $content['title'] }}</h2>
                @endif
            </div>
        </div>

        @if(!empty($content['faqs']))
        <div class="spacer-single"></div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="accordion" id="faqAccordion{{ $section->id }}">
                    @foreach($content['faqs'] as $index => $faq)
                    <div class="accordion-item wow fadeInUp" data-wow-delay=".{{ $index * 1 }}s">
                        <h3 class="accordion-header" id="faqHeading{{ $section->id }}_{{ $index }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#faqCollapse{{ $section->id }}_{{ $index }}"
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                    aria-controls="faqCollapse{{ $section->id }}_{{ $index }}">
                                {{ $faq['question'] ?? '' }}
                            </button>
                        </h3>
                        <div id="faqCollapse{{ $section->id }}_{{ $index }}"
                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                             aria-labelledby="faqHeading{{ $section->id }}_{{ $index }}"
                             data-bs-parent="#faqAccordion{{ $section->id }}">
                            <div class="accordion-body">
                                {{ $faq['answer'] ?? '' }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
