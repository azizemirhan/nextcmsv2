<?php

namespace App\Filament\Pages\Settings;

use App\Services\Settings\SettingsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class SocialSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-share';
    protected static ?string $navigationLabel = 'Social Media';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Settings';
    protected static string $view = 'filament.pages.settings.social-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(SettingsService::class);
        $this->form->fill([
            'facebook_url' => $settings->get('facebook_url'),
            'twitter_url' => $settings->get('twitter_url'),
            'instagram_url' => $settings->get('instagram_url'),
            'linkedin_url' => $settings->get('linkedin_url'),
            'youtube_url' => $settings->get('youtube_url'),
            'tiktok_url' => $settings->get('tiktok_url'),
            'whatsapp_number' => $settings->get('whatsapp_number'),
            'telegram_url' => $settings->get('telegram_url'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Social Media Links')
                    ->description('Add your social media profile URLs')
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url()
                            ->prefix('https://facebook.com/')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('Twitter/X')
                            ->url()
                            ->prefix('https://twitter.com/')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url()
                            ->prefix('https://instagram.com/')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url()
                            ->prefix('https://linkedin.com/')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->url()
                            ->prefix('https://youtube.com/')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('tiktok_url')
                            ->label('TikTok')
                            ->url()
                            ->prefix('https://tiktok.com/')
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make('Messaging')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('WhatsApp Number')
                            ->tel()
                            ->prefix('+')
                            ->helperText('Include country code (e.g., 905551234567)')
                            ->maxLength(20),
                        
                        Forms\Components\TextInput::make('telegram_url')
                            ->label('Telegram')
                            ->url()
                            ->prefix('https://t.me/')
                            ->maxLength(255),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = app(SettingsService::class);

        foreach ($data as $key => $value) {
            $settings->set($key, $value);
        }

        Notification::make()
            ->title('Social media settings saved successfully')
            ->success()
            ->send();
    }
}
