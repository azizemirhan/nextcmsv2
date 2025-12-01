<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Find or Create Home Page
        $page = Page::firstOrCreate(
            ['slug' => 'home'],
            [
                'title' => ['en' => 'Home', 'tr' => 'Anasayfa'],
                'is_active' => true,
                'banner_enabled' => false,
            ]
        );

        // Clear existing sections
        $page->sections()->delete();

        // Helper for localized content
        $loc = function ($en, $tr) {
            return ['en' => $en, 'tr' => $tr];
        };

        // 2. Create Sections

        // Hero Slider
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'hero-slider',
            'order' => 1,
            'is_active' => true,
            'content' => [
                'main_headline' => $loc('Brightening Tomorrow with Clean Solar Power.', 'Temiz Güneş Enerjisi ile Yarını Aydınlatıyoruz.'),
                'description' => $loc(
                    'At Solaria, we’re committed to delivering reliable, efficient, and sustainable solar energy solutions.',
                    'Solaria olarak, güvenilir, verimli ve sürdürülebilir güneş enerjisi çözümleri sunmaya kararlıyız.'
                ),
                'button_text' => $loc('Get Started', 'Hemen Başla'),
                'button_url' => 'get-a-quote.html',
                'box1_title' => $loc('When Sustainability Meets Style', 'Sürdürülebilirlik Tarzla Buluştuğunda'),
                'box1_desc' => $loc('Clean energy solutions designed to look great.', 'Harika görünen temiz enerji çözümleri.'),
                'box1_image' => 'misc/cst-1.webp',
                'box2_title' => $loc('Clean Energy for a Future', 'Gelecek İçin Temiz Enerji'),
                'box2_desc' => $loc('Choosing solar is a step toward a future.', 'Güneş enerjisi seçmek geleceğe bir adımdır.'),
                'box3_number' => '100K+',
                'box3_text' => $loc('home installed solar panel', 'eve güneş paneli kuruldu'),
                'slider_images' => [
                    ['image' => 'slider/3.webp'],
                    ['image' => 'slider/4.webp'],
                ],
            ],
        ]);

        // About & Stats
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'about-stats',
            'order' => 2,
            'is_active' => true,
            'content' => [
                'badge' => $loc('About Us', 'Hakkımızda'),
                'main_text' => $loc(
                    'Switch to solar and save money while saving the planet. <span class="op-3">Go green today!</span>',
                    'Güneş enerjisine geçin, hem tasarruf edin hem gezegeni koruyun. <span class="op-3">Bugün yeşile dönün!</span>'
                ),
                'stats' => [
                    [
                        'number' => 100,
                        'suffix' => 'K+',
                        'label' => $loc('Solar Panels Installed', 'Kurulan Güneş Paneli'),
                    ],
                    [
                        'number' => 25,
                        'suffix' => 'K+',
                        'label' => $loc('Homes Powered', 'Güç Verilen Ev'),
                    ],
                    [
                        'number' => 16,
                        'suffix' => '+',
                        'label' => $loc('Years of Solar Expertise', 'Yıllık Güneş Enerjisi Uzmanlığı'),
                    ],
                ],
            ],
        ]);

        // Features Split
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'features-split',
            'order' => 3,
            'is_active' => true,
            'content' => [
                'image_1' => 'misc/p1.webp',
                'image_2' => 'misc/p2.webp',
                'subtitle' => $loc('Solar Power for Smarter Future', 'Daha Akıllı Bir Gelecek İçin Güneş Enerjisi'),
                'title' => $loc('Clean, Reliable Energy Made <span class="op-3">Simple</span>', 'Temiz, Güvenilir Enerji <span class="op-3">Basitleştirildi</span>'),
                'description' => $loc('Discover the power of the sun with our end-to-end solar energy solutions.', 'Uçtan uca güneş enerjisi çözümlerimizle güneşin gücünü keşfedin.'),
                'features_list' => [
                    ['text' => $loc('Save money by generating your own power.', 'Kendi enerjinizi üreterek tasarruf edin.')],
                    ['text' => $loc('Reduce your carbon footprint.', 'Karbon ayak izinizi azaltın.')],
                    ['text' => $loc('Solar homes often see a higher resale value.', 'Güneş enerjili evlerin değeri artar.')],
                    ['text' => $loc('Reduce reliance on the grid.', 'Şebekeye bağımlılığı azaltın.')],
                ],
                'button_text' => $loc('Get a Quote', 'Teklif Al'),
                'button_url' => 'get-a-quote.html',
            ],
        ]);

        // Marquee
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'marquee',
            'order' => 4,
            'is_active' => true,
            'content' => [
                'background_style' => 'dark',
                'items' => [
                    ['text' => $loc('Solar Panel Installation', 'Güneş Paneli Kurulumu'), 'icon' => 'logo-icon-dark.webp'],
                    ['text' => $loc('Energy Storage Systems', 'Enerji Depolama Sistemleri'), 'icon' => 'logo-icon-dark.webp'],
                    ['text' => $loc('Off-Grid Solutions', 'Şebeke Bağımsız Çözümler'), 'icon' => 'logo-icon-dark.webp'],
                ],
            ],
        ]);

        // Services Grid
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'services-grid',
            'order' => 5,
            'is_active' => true,
            'content' => [
                'subtitle' => $loc('Solar Energy Services', 'Güneş Enerjisi Hizmetleri'),
                'title' => $loc('Reliable, Renewable Energy', 'Güvenilir, Yenilenebilir Enerji'),
                'description' => $loc('Switch to solar and enjoy lower bills.', 'Güneş enerjisine geçin ve düşük faturaların tadını çıkarın.'),
                'services' => [
                    [
                        'image' => 'services/1.webp',
                        'title' => $loc('Solar Panel Installation', 'Güneş Paneli Kurulumu'),
                        'description' => $loc('Fast, safe, and certified installation.', 'Hızlı, güvenli ve sertifikalı kurulum.'),
                        'link' => 'service-single.html',
                    ],
                    [
                        'image' => 'services/2.webp',
                        'title' => $loc('Solar Panel Maintenance', 'Güneş Paneli Bakımı'),
                        'description' => $loc('Ensure peak performance.', 'En yüksek performansı sağlayın.'),
                        'link' => 'service-single.html',
                    ],
                    [
                        'image' => 'services/3.webp',
                        'title' => $loc('Custom System Design', 'Özel Sistem Tasarımı'),
                        'description' => $loc('Efficient solar setups tailored to you.', 'Size özel verimli güneş enerjisi kurulumları.'),
                        'link' => 'service-single.html',
                    ],
                ],
                'view_all_text' => $loc('View All Services', 'Tüm Hizmetleri Gör'),
                'view_all_url' => 'services.html',
            ],
        ]);

        // Why Choose Us
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'why-choose-us',
            'order' => 6,
            'is_active' => true,
            'content' => [
                'stat_number' => '325%',
                'stat_text' => $loc('Average increase in solar panel', 'Güneş panelinde ortalama artış'),
                'image_main' => 'misc/s4.webp',
                'image_small' => 'misc/s1.webp',
                'subtitle' => $loc('Trusted & Affordable', 'Güvenilir & Uygun Fiyatlı'),
                'title' => $loc('Why Choose Us?', 'Neden Bizi Seçmelisiniz?'),
                'features' => [
                    ['title' => $loc('Professional Team', 'Profesyonel Ekip'), 'description' => $loc('Certified professionals.', 'Sertifikalı profesyoneller.')],
                    ['title' => $loc('Customized Solutions', 'Özel Çözümler'), 'description' => $loc('Tailored to your needs.', 'İhtiyaçlarınıza özel.')],
                    ['title' => $loc('Affordable Plans', 'Uygun Planlar'), 'description' => $loc('Flexible financing.', 'Esnek finansman.')],
                    ['title' => $loc('Ongoing Support', 'Sürekli Destek'), 'description' => $loc('Full-service maintenance.', 'Tam hizmet bakımı.')],
                ],
            ],
        ]);

        // Projects Carousel
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'projects-carousel',
            'order' => 7,
            'is_active' => true,
            'content' => [
                'subtitle' => $loc('Our Solar Projects', 'Güneş Enerjisi Projelerimiz'),
                'title' => $loc('Powering a Brighter Future', 'Daha Parlak Bir Geleceğe Güç Veriyoruz'),
                'description' => $loc('Explore our latest solar installations.', 'En son güneş enerjisi kurulumlarımızı keşfedin.'),
                'projects' => [
                    ['image' => 'projects/1.webp', 'title' => 'BrightHome Energy', 'category' => $loc('Home Installation', 'Ev Kurulumu')],
                    ['image' => 'projects/2.webp', 'title' => 'GreenMart Supermarket', 'category' => $loc('Solar Panel Upgrades', 'Panel Yükseltme')],
                    ['image' => 'projects/3.webp', 'title' => 'EcoSchool Initiative', 'category' => $loc('Custom System Design', 'Özel Sistem Tasarımı')],
                ],
            ],
        ]);

        // Testimonials Split
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'testimonials-split',
            'order' => 8,
            'is_active' => true,
            'content' => [
                'image' => 'misc/s2.webp',
                'testimonials' => [
                    [
                        'quote' => $loc('Switching to solar was the best decision.', 'Güneş enerjisine geçmek en iyi karardı.'),
                        'author' => 'Alex Morgan',
                    ],
                    [
                        'quote' => $loc('Reliable, affordable, and eco-friendly.', 'Güvenilir, uygun fiyatlı ve çevre dostu.'),
                        'author' => 'Jamie Chen',
                    ],
                ],
            ],
        ]);

        // FAQ Accordion
        PageSection::create([
            'page_id' => $page->id,
            'section_key' => 'faq-accordion',
            'order' => 10,
            'is_active' => true,
            'content' => [
                'subtitle' => $loc('Everything You Need to Know', 'Bilmeniz Gereken Her Şey'),
                'title' => $loc('Frequently Asked Questions', 'Sıkça Sorulan Sorular'),
                'faqs' => [
                    [
                        'question' => $loc('How much can I save?', 'Ne kadar tasarruf edebilirim?'),
                        'answer' => $loc('Most homeowners save 20-50%.', 'Çoğu ev sahibi %20-50 tasarruf eder.'),
                    ],
                    [
                        'question' => $loc('What happens if it’s cloudy?', 'Hava bulutluysa ne olur?'),
                        'answer' => $loc('Solar panels still generate power.', 'Güneş panelleri hala güç üretir.'),
                    ],
                ],
            ],
        ]);
    }
}
