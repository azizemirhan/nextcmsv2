<?php

namespace Database\Seeders;

use App\Models\SectionTemplate;
use Illuminate\Database\Seeder;

class SectionTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            // 1. Hero Slider Section
            [
                'key' => 'hero-slider',
                'name' => ['en' => 'Hero Slider', 'tr' => 'Ana Slider'],
                'category' => 'hero',
                'description' => ['en' => 'Full-width hero slider with background images, title, subtitle and CTA button', 'tr' => 'Arka plan resimleri, başlık, alt başlık ve CTA butonu ile tam genişlik hero slider'],
                'view_path' => 'sections.hero-slider',
                'fields_schema' => [
                    'main_headline' => ['type' => 'translatable_text', 'label' => 'Main Headline', 'required' => true],
                    'description' => ['type' => 'translatable_textarea', 'label' => 'Description'],
                    'button_text' => ['type' => 'translatable_text', 'label' => 'Button Text'],
                    'button_url' => ['type' => 'text', 'label' => 'Button URL'],
                    'box1_title' => ['type' => 'translatable_text', 'label' => 'Box 1 Title'],
                    'box1_desc' => ['type' => 'translatable_textarea', 'label' => 'Box 1 Description'],
                    'box1_image' => ['type' => 'media', 'label' => 'Box 1 Image'],
                    'box2_title' => ['type' => 'translatable_text', 'label' => 'Box 2 Title'],
                    'box2_desc' => ['type' => 'translatable_textarea', 'label' => 'Box 2 Description'],
                    'box3_number' => ['type' => 'text', 'label' => 'Box 3 Number'],
                    'box3_text' => ['type' => 'translatable_text', 'label' => 'Box 3 Text'],
                    'slider_images' => ['type' => 'repeater', 'label' => 'Slider Images', 'fields' => [
                        'image' => ['type' => 'media', 'label' => 'Image'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 1,
            ],

            // 2. About & Stats
            [
                'key' => 'about-stats',
                'name' => ['en' => 'About & Stats', 'tr' => 'Hakkımızda & İstatistikler'],
                'category' => 'statistics',
                'description' => ['en' => 'About section with statistics counters', 'tr' => 'İstatistik sayaçları ile hakkımızda bölümü'],
                'view_path' => 'sections.about-stats',
                'fields_schema' => [
                    'badge' => ['type' => 'translatable_text', 'label' => 'Badge Text'],
                    'main_text' => ['type' => 'translatable_textarea', 'label' => 'Main Text'],
                    'stats' => ['type' => 'repeater', 'label' => 'Statistics', 'fields' => [
                        'number' => ['type' => 'number', 'label' => 'Number'],
                        'suffix' => ['type' => 'text', 'label' => 'Suffix'],
                        'label' => ['type' => 'translatable_text', 'label' => 'Label'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 2,
            ],

            // 3. Features Split
            [
                'key' => 'features-split',
                'name' => ['en' => 'Features Split', 'tr' => 'Özellikler (Bölünmüş)'],
                'category' => 'features',
                'description' => ['en' => 'Features section with split layout and images', 'tr' => 'Bölünmüş düzen ve resimlerle özellikler bölümü'],
                'view_path' => 'sections.features-split',
                'fields_schema' => [
                    'subtitle' => ['type' => 'translatable_text', 'label' => 'Subtitle'],
                    'title' => ['type' => 'translatable_text', 'label' => 'Title'],
                    'description' => ['type' => 'translatable_textarea', 'label' => 'Description'],
                    'image_1' => ['type' => 'media', 'label' => 'Image 1'],
                    'image_2' => ['type' => 'media', 'label' => 'Image 2'],
                    'features_list' => ['type' => 'repeater', 'label' => 'Features List', 'fields' => [
                        'text' => ['type' => 'translatable_text', 'label' => 'Feature Text'],
                    ]],
                    'button_text' => ['type' => 'translatable_text', 'label' => 'Button Text'],
                    'button_url' => ['type' => 'text', 'label' => 'Button URL'],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 3,
            ],

            // 4. Marquee
            [
                'key' => 'marquee',
                'name' => ['en' => 'Marquee', 'tr' => 'Kayan Yazı'],
                'category' => 'content',
                'description' => ['en' => 'Scrolling text marquee', 'tr' => 'Kayan metin şeridi'],
                'view_path' => 'sections.marquee',
                'fields_schema' => [
                    'background_style' => ['type' => 'select', 'label' => 'Background Style', 'options' => ['light' => 'Light', 'dark' => 'Dark']],
                    'items' => ['type' => 'repeater', 'label' => 'Marquee Items', 'fields' => [
                        'text' => ['type' => 'translatable_text', 'label' => 'Text'],
                        'icon' => ['type' => 'media', 'label' => 'Icon'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 4,
            ],

            // 5. Services Grid
            [
                'key' => 'services-grid',
                'name' => ['en' => 'Services Grid', 'tr' => 'Hizmetler Grid'],
                'category' => 'services',
                'description' => ['en' => 'Display services in responsive grid layout', 'tr' => 'Responsive grid düzeninde hizmetleri göster'],
                'view_path' => 'sections.services-grid',
                'fields_schema' => [
                    'subtitle' => ['type' => 'translatable_text', 'label' => 'Subtitle'],
                    'title' => ['type' => 'translatable_text', 'label' => 'Main Title'],
                    'description' => ['type' => 'translatable_textarea', 'label' => 'Description'],
                    'services' => ['type' => 'repeater', 'label' => 'Services', 'fields' => [
                        'image' => ['type' => 'media', 'label' => 'Service Image'],
                        'title' => ['type' => 'translatable_text', 'label' => 'Service Title'],
                        'description' => ['type' => 'translatable_text', 'label' => 'Short Description'],
                        'link' => ['type' => 'text', 'label' => 'Link URL'],
                    ]],
                    'view_all_text' => ['type' => 'translatable_text', 'label' => 'View All Button'],
                    'view_all_url' => ['type' => 'text', 'label' => 'View All URL'],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 5,
            ],

            // 6. Why Choose Us
            [
                'key' => 'why-choose-us',
                'name' => ['en' => 'Why Choose Us', 'tr' => 'Neden Biz'],
                'category' => 'features',
                'description' => ['en' => 'Why choose us section with stats and features', 'tr' => 'İstatistikler ve özellikler ile neden biz bölümü'],
                'view_path' => 'sections.why-choose-us',
                'fields_schema' => [
                    'subtitle' => ['type' => 'translatable_text', 'label' => 'Subtitle'],
                    'title' => ['type' => 'translatable_text', 'label' => 'Title'],
                    'stat_number' => ['type' => 'text', 'label' => 'Stat Number'],
                    'stat_text' => ['type' => 'translatable_text', 'label' => 'Stat Text'],
                    'image_main' => ['type' => 'media', 'label' => 'Main Image'],
                    'image_small' => ['type' => 'media', 'label' => 'Small Image'],
                    'features' => ['type' => 'repeater', 'label' => 'Features', 'fields' => [
                        'title' => ['type' => 'translatable_text', 'label' => 'Title'],
                        'description' => ['type' => 'translatable_textarea', 'label' => 'Description'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 6,
            ],

            // 7. Projects Carousel
            [
                'key' => 'projects-carousel',
                'name' => ['en' => 'Projects Carousel', 'tr' => 'Projeler Carousel'],
                'category' => 'portfolio',
                'description' => ['en' => 'Showcase projects in carousel slider', 'tr' => 'Carousel slider ile projeleri göster'],
                'view_path' => 'sections.projects-carousel',
                'fields_schema' => [
                    'subtitle' => ['type' => 'translatable_text', 'label' => 'Subtitle'],
                    'title' => ['type' => 'translatable_text', 'label' => 'Title'],
                    'description' => ['type' => 'translatable_textarea', 'label' => 'Description'],
                    'projects' => ['type' => 'repeater', 'label' => 'Projects', 'fields' => [
                        'image' => ['type' => 'media', 'label' => 'Project Image'],
                        'title' => ['type' => 'translatable_text', 'label' => 'Project Name'],
                        'category' => ['type' => 'translatable_text', 'label' => 'Category'],
                        'link' => ['type' => 'text', 'label' => 'Project URL'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 7,
            ],

            // 8. Testimonials Split
            [
                'key' => 'testimonials-split',
                'name' => ['en' => 'Testimonials Split', 'tr' => 'Müşteri Yorumları (Bölünmüş)'],
                'category' => 'testimonials',
                'description' => ['en' => 'Customer testimonials with image', 'tr' => 'Resimli müşteri yorumları'],
                'view_path' => 'sections.testimonials-split',
                'fields_schema' => [
                    'image' => ['type' => 'media', 'label' => 'Image'],
                    'testimonials' => ['type' => 'repeater', 'label' => 'Testimonials', 'fields' => [
                        'quote' => ['type' => 'translatable_textarea', 'label' => 'Quote'],
                        'author' => ['type' => 'text', 'label' => 'Author Name'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 8,
            ],

            // 9. FAQ Accordion
            [
                'key' => 'faq-accordion',
                'name' => ['en' => 'FAQ Accordion', 'tr' => 'SSS Accordion'],
                'category' => 'faq',
                'description' => ['en' => 'Frequently asked questions with accordion', 'tr' => 'Accordion ile sık sorulan sorular'],
                'view_path' => 'sections.faq-accordion',
                'fields_schema' => [
                    'subtitle' => ['type' => 'translatable_text', 'label' => 'Subtitle'],
                    'title' => ['type' => 'translatable_text', 'label' => 'Section Title'],
                    'faqs' => ['type' => 'repeater', 'label' => 'FAQs', 'fields' => [
                        'question' => ['type' => 'translatable_text', 'label' => 'Question'],
                        'answer' => ['type' => 'translatable_textarea', 'label' => 'Answer'],
                    ]],
                ],
                'preview_image' => null,
                'is_premium' => false,
                'order' => 9,
            ],
        ];

        foreach ($sections as $section) {
            SectionTemplate::updateOrCreate(
                ['key' => $section['key']],
                $section
            );
        }

        $this->command->info('✅ Created 8 section templates');
    }
}
