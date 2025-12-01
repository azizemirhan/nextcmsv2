<?php

namespace App\Filament\Pages\Settings;

use App\Services\Settings\SettingsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ContactSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = 'Contact Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.settings.contact-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(SettingsService::class);
        $this->form->fill([
            'contact_email' => $settings->get('contact_email'),
            'contact_phone' => $settings->get('contact_phone'),
            'contact_address' => $settings->get('contact_address'),
            'contact_city' => $settings->get('contact_city'),
            'contact_state' => $settings->get('contact_state'),
            'contact_country' => $settings->get('contact_country'),
            'contact_postal_code' => $settings->get('contact_postal_code'),
            'google_maps_link' => $settings->get('google_maps_link'),
            'google_maps_embed' => $settings->get('google_maps_embed'),
            'contact_working_hours' => $settings->get('contact_working_hours'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(50),
                    ]),

                Forms\Components\Section::make('Address')
                    ->schema([
                        Forms\Components\Textarea::make('contact_address')
                            ->label('Street Address')
                            ->rows(2)
                            ->maxLength(500),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('contact_city')
                                    ->label('City')
                                    ->maxLength(100),
                                
                                Forms\Components\TextInput::make('contact_state')
                                    ->label('State/Province')
                                    ->maxLength(100),
                            ]),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('contact_country')
                                    ->label('Country')
                                    ->maxLength(100),
                                
                                Forms\Components\TextInput::make('contact_postal_code')
                                    ->label('Postal Code')
                                    ->maxLength(20),
                            ]),
                    ]),

                Forms\Components\Section::make('Google Maps')
                    ->schema([
                        Forms\Components\TextInput::make('google_maps_link')
                            ->label('Google Maps Link')
                            ->url()
                            ->maxLength(500)
                            ->helperText('Full URL to location on Google Maps'),
                        
                        Forms\Components\Textarea::make('google_maps_embed')
                            ->label('Google Maps Embed Code')
                            ->rows(4)
                            ->helperText('Paste the iframe embed code from Google Maps'),
                    ]),

                Forms\Components\Section::make('Working Hours')
                    ->schema([
                        Forms\Components\Textarea::make('contact_working_hours')
                            ->label('Working Hours')
                            ->rows(5)
                            ->helperText('e.g., Mon-Fri: 9:00 AM - 6:00 PM'),
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
            ->title('Contact settings saved successfully')
            ->success()
            ->send();
    }
}
