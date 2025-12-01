<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hero Slider Section (Homepage 1)
    |--------------------------------------------------------------------------
    */
    'hero-slider' => [
        'name' => 'Hero Slider (Home)',
        'description' => 'Main hero section with slider background and grid content',
        'category' => 'hero',
        'icon' => 'heroicon-o-photo',
        'view' => 'sections.hero-slider',
        'fields' => [
            [
                'name' => 'main_headline',
                'label' => 'Main Headline',
                'type' => 'textarea',
                'translatable' => true,
                'default' => 'Brightening Tomorrow with Clean Solar Power.',
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'translatable' => true,
                'default' => 'At Solaria, we’re committed to delivering reliable, efficient, and sustainable solar energy solutions.',
            ],
            [
                'name' => 'button_text',
                'label' => 'Button Text',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Get Started',
            ],
            [
                'name' => 'button_url',
                'label' => 'Button URL',
                'type' => 'text',
                'default' => 'get-a-quote.html',
            ],
            // Right Grid Content
            [
                'name' => 'box1_title',
                'label' => 'Box 1 Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'When Sustainability Meets Style',
            ],
            [
                'name' => 'box1_desc',
                'label' => 'Box 1 Description',
                'type' => 'textarea',
                'translatable' => true,
                'default' => 'Clean energy solutions designed to look great and perform efficiently.',
            ],
            [
                'name' => 'box1_image',
                'label' => 'Box 1 Image',
                'type' => 'file',
            ],
            [
                'name' => 'box2_title',
                'label' => 'Box 2 Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Clean Energy for a Future',
            ],
            [
                'name' => 'box2_desc',
                'label' => 'Box 2 Description',
                'type' => 'textarea',
                'translatable' => true,
                'default' => 'Choosing solar is a step toward a future powered by clean energy.',
            ],
            [
                'name' => 'box3_number',
                'label' => 'Box 3 Number',
                'type' => 'text',
                'default' => '100K+',
            ],
            [
                'name' => 'box3_text',
                'label' => 'Box 3 Text',
                'type' => 'text',
                'translatable' => true,
                'default' => 'home installed solar panel',
            ],
            // Slider Images
            [
                'name' => 'slider_images',
                'label' => 'Background Slider Images',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => 'Image',
                        'type' => 'file',
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | About & Stats Section
    |--------------------------------------------------------------------------
    */
    'about-stats' => [
        'name' => 'About & Stats',
        'description' => 'About text with statistics counters',
        'category' => 'content',
        'icon' => 'heroicon-o-chart-bar',
        'view' => 'sections.about-stats',
        'fields' => [
            [
                'name' => 'badge',
                'label' => 'Badge (Small Title)',
                'type' => 'text',
                'translatable' => true,
                'default' => 'About Us',
            ],
            [
                'name' => 'main_text',
                'label' => 'Main Text',
                'type' => 'textarea',
                'translatable' => true,
                'help' => 'Use HTML for highlighting (e.g. <span class="op-3">...</span>)',
            ],
            [
                'name' => 'stats',
                'label' => 'Statistics',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'number',
                        'label' => 'Number',
                        'type' => 'number',
                    ],
                    [
                        'name' => 'suffix',
                        'label' => 'Suffix (e.g. K+)',
                        'type' => 'text',
                    ],
                    [
                        'name' => 'label',
                        'label' => 'Label',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Features Split Section (Image + Text)
    |--------------------------------------------------------------------------
    */
    'features-split' => [
        'name' => 'Features Split (Image + Text)',
        'description' => 'Split section with overlapping images and feature list',
        'category' => 'content',
        'icon' => 'heroicon-o-photo',
        'view' => 'sections.features-split',
        'fields' => [
            [
                'name' => 'image_1',
                'label' => 'Main Image',
                'type' => 'file',
            ],
            [
                'name' => 'image_2',
                'label' => 'Secondary Image (Overlay)',
                'type' => 'file',
            ],
            [
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Solar Power for Smarter Future',
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Clean, Reliable Energy Made Simple',
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'translatable' => true,
            ],
            [
                'name' => 'features_list',
                'label' => 'Features List',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'text',
                        'label' => 'Feature Text',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                ],
            ],
            [
                'name' => 'button_text',
                'label' => 'Button Text',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Get a Quote',
            ],
            [
                'name' => 'button_url',
                'label' => 'Button URL',
                'type' => 'text',
                'default' => 'get-a-quote.html',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Marquee Section
    |--------------------------------------------------------------------------
    */
    'marquee' => [
        'name' => 'Marquee (Scrolling Text)',
        'description' => 'Infinite scrolling text strip',
        'category' => 'content',
        'icon' => 'heroicon-o-arrows-right-left',
        'view' => 'sections.marquee',
        'fields' => [
            [
                'name' => 'background_style',
                'label' => 'Background Style',
                'type' => 'select',
                'options' => [
                    'dark' => 'Dark',
                    'light' => 'Light',
                    'color' => 'Primary Color',
                ],
                'default' => 'dark',
            ],
            [
                'name' => 'items',
                'label' => 'Marquee Items',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'text',
                        'label' => 'Text',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'icon',
                        'label' => 'Icon Image (Optional)',
                        'type' => 'file',
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Services Grid Section
    |--------------------------------------------------------------------------
    */
    'services-grid' => [
        'name' => 'Services Grid',
        'description' => 'Grid of services with images and hover effects',
        'category' => 'services',
        'icon' => 'heroicon-o-squares-2x2',
        'view' => 'sections.services-grid',
        'fields' => [
            [
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Solar Energy Services',
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Reliable, Renewable, and Cost-Effective Energy',
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'translatable' => true,
            ],
            [
                'name' => 'services',
                'label' => 'Services',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => 'Image',
                        'type' => 'file',
                    ],
                    [
                        'name' => 'title',
                        'label' => 'Title',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => 'Description',
                        'type' => 'textarea',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'link',
                        'label' => 'Link URL',
                        'type' => 'text',
                        'default' => 'service-single.html',
                    ],
                ],
            ],
            [
                'name' => 'view_all_text',
                'label' => 'View All Button Text',
                'type' => 'text',
                'translatable' => true,
                'default' => 'View All Services',
            ],
            [
                'name' => 'view_all_url',
                'label' => 'View All URL',
                'type' => 'text',
                'default' => 'services.html',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Why Choose Us Section
    |--------------------------------------------------------------------------
    */
    'why-choose-us' => [
        'name' => 'Why Choose Us',
        'description' => 'Dark section with stats and feature grid',
        'category' => 'content',
        'icon' => 'heroicon-o-check-badge',
        'view' => 'sections.why-choose-us',
        'fields' => [
            [
                'name' => 'stat_number',
                'label' => 'Main Stat Number',
                'type' => 'text',
                'default' => '325%',
            ],
            [
                'name' => 'stat_text',
                'label' => 'Main Stat Text',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Average increase in solar panel',
            ],
            [
                'name' => 'image_main',
                'label' => 'Main Image',
                'type' => 'file',
            ],
            [
                'name' => 'image_small',
                'label' => 'Small Image',
                'type' => 'file',
            ],
            [
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Trusted & Affordable',
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Why Choose Us?',
            ],
            [
                'name' => 'features',
                'label' => 'Features Grid',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'title',
                        'label' => 'Title',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => 'Description',
                        'type' => 'textarea',
                        'translatable' => true,
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Projects Carousel Section
    |--------------------------------------------------------------------------
    */
    'projects-carousel' => [
        'name' => 'Projects Carousel',
        'description' => 'Carousel of project cards',
        'category' => 'projects',
        'icon' => 'heroicon-o-briefcase',
        'view' => 'sections.projects-carousel',
        'fields' => [
            [
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Our Solar Projects',
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Powering a Brighter Future',
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'translatable' => true,
            ],
            [
                'name' => 'projects',
                'label' => 'Projects',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => 'Project Image',
                        'type' => 'file',
                    ],
                    [
                        'name' => 'title',
                        'label' => 'Project Title',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'category',
                        'label' => 'Category',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'link',
                        'label' => 'Link URL',
                        'type' => 'text',
                        'default' => 'project-single.html',
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Testimonials Split Section
    |--------------------------------------------------------------------------
    */
    'testimonials-split' => [
        'name' => 'Testimonials Split',
        'description' => 'Split section with image and testimonials slider',
        'category' => 'social-proof',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'view' => 'sections.testimonials-split',
        'fields' => [
            [
                'name' => 'image',
                'label' => 'Side Image',
                'type' => 'file',
            ],
            [
                'name' => 'testimonials',
                'label' => 'Testimonials',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'quote',
                        'label' => 'Quote',
                        'type' => 'textarea',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'author',
                        'label' => 'Author Name',
                        'type' => 'text',
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | FAQ Section
    |--------------------------------------------------------------------------
    */
    'faq-accordion' => [
        'name' => 'FAQ Accordion',
        'description' => 'Frequently Asked Questions with accordion',
        'category' => 'content',
        'icon' => 'heroicon-o-question-mark-circle',
        'view' => 'sections.faq-accordion',
        'fields' => [
            [
                'name' => 'subtitle',
                'label' => 'Subtitle',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Everything You Need to Know',
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'Frequently Asked Questions',
            ],
            [
                'name' => 'faqs',
                'label' => 'Questions',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'question',
                        'label' => 'Question',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'answer',
                        'label' => 'Answer',
                        'type' => 'textarea',
                        'translatable' => true,
                    ],
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Video Section
    |--------------------------------------------------------------------------
    */
    'video-section' => [
        'name' => 'Video Section',
        'description' => 'Video popup with background image',
        'category' => 'media',
        'icon' => 'heroicon-o-video-camera',
        'view' => 'sections.video-section',
        'fields' => [
            [
                'name' => 'background_image',
                'label' => 'Background Image',
                'type' => 'file',
            ],
            [
                'name' => 'video_url',
                'label' => 'Video URL (YouTube/Vimeo)',
                'type' => 'text',
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'translatable' => true,
                'default' => 'See How It Works',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Info Bar
    |--------------------------------------------------------------------------
    */
    'contact-info-bar' => [
        'name' => 'Contact Info Bar',
        'description' => 'Bar with contact details (Phone, Email, Location)',
        'category' => 'contact',
        'icon' => 'heroicon-o-phone',
        'view' => 'sections.contact-info-bar',
        'fields' => [
            [
                'name' => 'items',
                'label' => 'Contact Items',
                'type' => 'repeater',
                'fields' => [
                    [
                        'name' => 'icon',
                        'label' => 'Icon Class',
                        'type' => 'text',
                        'default' => 'icofont-phone',
                    ],
                    [
                        'name' => 'title',
                        'label' => 'Title',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                    [
                        'name' => 'subtitle',
                        'label' => 'Subtitle/Value',
                        'type' => 'text',
                        'translatable' => true,
                    ],
                ],
            ],
        ],
    ],
];
