<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\SettingsGroup;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            [
                'key' => 'general',
                'name' => ['en' => 'General', 'tr' => 'Genel'],
                'description' => ['en' => 'General site settings', 'tr' => 'Genel site ayarları'],
                'icon' => 'heroicon-o-cog-6-tooth',
                'order' => 1,
            ],
            [
                'key' => 'contact',
                'name' => ['en' => 'Contact', 'tr' => 'İletişim'],
                'description' => ['en' => 'Contact information', 'tr' => 'İletişim bilgileri'],
                'icon' => 'heroicon-o-phone',
                'order' => 2,
            ],
            [
                'key' => 'social',
                'name' => ['en' => 'Social Media', 'tr' => 'Sosyal Medya'],
                'description' => ['en' => 'Social media links', 'tr' => 'Sosyal medya linkleri'],
                'icon' => 'heroicon-o-share',
                'order' => 3,
            ],
            [
                'key' => 'mail',
                'name' => ['en' => 'Mail', 'tr' => 'E-posta'],
                'description' => ['en' => 'Email settings', 'tr' => 'E-posta ayarları'],
                'icon' => 'heroicon-o-envelope',
                'order' => 4,
            ],
        ];

        foreach ($groups as $groupData) {
            SettingsGroup::updateOrCreate(
                ['key' => $groupData['key']],
                $groupData
            );
        }

        $settings = [
            // General Settings
            ['group' => 'general', 'key' => 'site_name', 'label' => ['en' => 'Site Name', 'tr' => 'Site Adı'], 'type' => 'text', 'default_value' => config('app.name'), 'order' => 1],
            ['group' => 'general', 'key' => 'site_description', 'label' => ['en' => 'Site Description', 'tr' => 'Site Açıklaması'], 'type' => 'textarea', 'order' => 2],
            ['group' => 'general', 'key' => 'site_logo', 'label' => ['en' => 'Site Logo', 'tr' => 'Site Logosu'], 'type' => 'image', 'order' => 3],
            ['group' => 'general', 'key' => 'site_favicon', 'label' => ['en' => 'Site Favicon', 'tr' => 'Site İkonu'], 'type' => 'image', 'order' => 4],
            ['group' => 'general', 'key' => 'site_language', 'label' => ['en' => 'Default Language', 'tr' => 'Varsayılan Dil'], 'type' => 'select', 'default_value' => 'en', 'options' => ['en' => 'English', 'tr' => 'Türkçe'], 'order' => 5],
            ['group' => 'general', 'key' => 'timezone', 'label' => ['en' => 'Timezone', 'tr' => 'Zaman Dilimi'], 'type' => 'select', 'default_value' => 'UTC', 'order' => 6],
            ['group' => 'general', 'key' => 'date_format', 'label' => ['en' => 'Date Format', 'tr' => 'Tarih Formatı'], 'type' => 'text', 'default_value' => 'd/m/Y', 'order' => 7],
            ['group' => 'general', 'key' => 'time_format', 'label' => ['en' => 'Time Format', 'tr' => 'Saat Formatı'], 'type' => 'text', 'default_value' => 'H:i', 'order' => 8],
            ['group' => 'general', 'key' => 'items_per_page', 'label' => ['en' => 'Items Per Page', 'tr' => 'Sayfa Başına Öğe'], 'type' => 'number', 'default_value' => 15, 'order' => 9],
            ['group' => 'general', 'key' => 'maintenance_mode', 'label' => ['en' => 'Maintenance Mode', 'tr' => 'Bakım Modu'], 'type' => 'boolean', 'default_value' => false, 'order' => 10],
            ['group' => 'general', 'key' => 'maintenance_message', 'label' => ['en' => 'Maintenance Message', 'tr' => 'Bakım Mesajı'], 'type' => 'textarea', 'order' => 11],

            // Contact Settings
            ['group' => 'contact', 'key' => 'contact_email', 'label' => ['en' => 'Email', 'tr' => 'E-posta'], 'type' => 'text', 'order' => 1],
            ['group' => 'contact', 'key' => 'contact_phone', 'label' => ['en' => 'Phone', 'tr' => 'Telefon'], 'type' => 'text', 'order' => 2],
            ['group' => 'contact', 'key' => 'contact_address', 'label' => ['en' => 'Address', 'tr' => 'Adres'], 'type' => 'textarea', 'order' => 3],
            ['group' => 'contact', 'key' => 'contact_city', 'label' => ['en' => 'City', 'tr' => 'Şehir'], 'type' => 'text', 'order' => 4],
            ['group' => 'contact', 'key' => 'contact_state', 'label' => ['en' => 'State', 'tr' => 'Eyalet'], 'type' => 'text', 'order' => 5],
            ['group' => 'contact', 'key' => 'contact_country', 'label' => ['en' => 'Country', 'tr' => 'Ülke'], 'type' => 'text', 'order' => 6],
            ['group' => 'contact', 'key' => 'contact_postal_code', 'label' => ['en' => 'Postal Code', 'tr' => 'Posta Kodu'], 'type' => 'text', 'order' => 7],
            ['group' => 'contact', 'key' => 'google_maps_link', 'label' => ['en' => 'Google Maps Link', 'tr' => 'Google Maps Linki'], 'type' => 'text', 'order' => 8],
            ['group' => 'contact', 'key' => 'google_maps_embed', 'label' => ['en' => 'Google Maps Embed', 'tr' => 'Google Maps Yerleştirme'], 'type' => 'textarea', 'order' => 9],
            ['group' => 'contact', 'key' => 'contact_working_hours', 'label' => ['en' => 'Working Hours', 'tr' => 'Çalışma Saatleri'], 'type' => 'textarea', 'order' => 10],

            // Social Media Settings
            ['group' => 'social', 'key' => 'facebook_url', 'label' => ['en' => 'Facebook', 'tr' => 'Facebook'], 'type' => 'text', 'order' => 1],
            ['group' => 'social', 'key' => 'twitter_url', 'label' => ['en' => 'Twitter', 'tr' => 'Twitter'], 'type' => 'text', 'order' => 2],
            ['group' => 'social', 'key' => 'instagram_url', 'label' => ['en' => 'Instagram', 'tr' => 'Instagram'], 'type' => 'text', 'order' => 3],
            ['group' => 'social', 'key' => 'linkedin_url', 'label' => ['en' => 'LinkedIn', 'tr' => 'LinkedIn'], 'type' => 'text', 'order' => 4],
            ['group' => 'social', 'key' => 'youtube_url', 'label' => ['en' => 'YouTube', 'tr' => 'YouTube'], 'type' => 'text', 'order' => 5],
            ['group' => 'social', 'key' => 'tiktok_url', 'label' => ['en' => 'TikTok', 'tr' => 'TikTok'], 'type' => 'text', 'order' => 6],
            ['group' => 'social', 'key' => 'whatsapp_number', 'label' => ['en' => 'WhatsApp', 'tr' => 'WhatsApp'], 'type' => 'text', 'order' => 7],
            ['group' => 'social', 'key' => 'telegram_url', 'label' => ['en' => 'Telegram', 'tr' => 'Telegram'], 'type' => 'text', 'order' => 8],

            // Mail Settings
            ['group' => 'mail', 'key' => 'mail_from_address', 'label' => ['en' => 'From Address', 'tr' => 'Gönderen Adresi'], 'type' => 'text', 'default_value' => config('mail.from.address'), 'order' => 1],
            ['group' => 'mail', 'key' => 'mail_from_name', 'label' => ['en' => 'From Name', 'tr' => 'Gönderen Adı'], 'type' => 'text', 'default_value' => config('mail.from.name'), 'order' => 2],
            ['group' => 'mail', 'key' => 'mail_contact_recipient', 'label' => ['en' => 'Contact Form Recipient', 'tr' => 'İletişim Formu Alıcısı'], 'type' => 'text', 'order' => 3],
            ['group' => 'mail', 'key' => 'mail_notification_recipient', 'label' => ['en' => 'Notification Recipient', 'tr' => 'Bildirim Alıcısı'], 'type' => 'text', 'order' => 4],
        ];

        foreach ($settings as $settingData) {
            $group = SettingsGroup::where('key', $settingData['group'])->first();
            
            if ($group) {
                Setting::updateOrCreate(
                    ['key' => $settingData['key']],
                    [
                        'group_id' => $group->id,
                        'label' => $settingData['label'],
                        'type' => $settingData['type'],
                        'default_value' => $settingData['default_value'] ?? null,
                        'options' => $settingData['options'] ?? null,
                        'order' => $settingData['order'],
                    ]
                );
            }
        }

        $this->command->info('✅ Settings seeded successfully');
    }
}
