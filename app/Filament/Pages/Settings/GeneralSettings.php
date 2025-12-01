<?php

namespace App\Filament\Pages\Settings;

use App\Services\Settings\SettingsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class GeneralSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'General Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.settings.general-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(SettingsService::class);
        $this->form->fill([
            'site_name' => $settings->get('site_name', config('app.name')),
            'site_description' => $settings->get('site_description'),
            'site_logo' => $settings->get('site_logo'),
            'site_favicon' => $settings->get('site_favicon'),
            'site_language' => $settings->get('site_language', 'en'),
            'timezone' => $settings->get('timezone', config('app.timezone')),
            'date_format' => $settings->get('date_format', 'd/m/Y'),
            'time_format' => $settings->get('time_format', 'H:i'),
            'items_per_page' => $settings->get('items_per_page', 15),
            'maintenance_mode' => $settings->get('maintenance_mode', false),
            'maintenance_message' => $settings->get('maintenance_message'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Site Information')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('site_description')
                            ->label('Site Description')
                            ->rows(3)
                            ->maxLength(500),
                        
                        Forms\Components\FileUpload::make('site_logo')
                            ->label('Site Logo')
                            ->image()
                            ->directory('settings')
                            ->maxSize(2048),
                        
                        Forms\Components\FileUpload::make('site_favicon')
                            ->label('Site Favicon')
                            ->image()
                            ->directory('settings')
                            ->maxSize(512)
                            ->helperText('Recommended: 32x32px or 64x64px'),
                    ]),

                Forms\Components\Section::make('Localization')
                    ->schema([
                        Forms\Components\Select::make('site_language')
                            ->label('Default Language')
                            ->options([
                                'en' => 'English',
                                'tr' => 'Türkçe',
                            ])
                            ->required(),
                        
                        Forms\Components\Select::make('timezone')
                            ->label('Timezone')
                            ->options(collect(timezone_identifiers_list())->mapWithKeys(fn($tz) => [$tz => $tz]))
                            ->searchable()
                            ->required(),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('date_format')
                                    ->label('Date Format')
                                    ->required()
                                    ->helperText('e.g., d/m/Y, Y-m-d'),
                                
                                Forms\Components\TextInput::make('time_format')
                                    ->label('Time Format')
                                    ->required()
                                    ->helperText('e.g., H:i, h:i A'),
                            ]),
                    ]),

                Forms\Components\Section::make('General Options')
                    ->schema([
                        Forms\Components\TextInput::make('items_per_page')
                            ->label('Items Per Page')
                            ->numeric()
                            ->required()
                            ->minValue(5)
                            ->maxValue(100)
                            ->default(15),
                    ]),

                Forms\Components\Section::make('Maintenance Mode')
                    ->schema([
                        Forms\Components\Toggle::make('maintenance_mode')
                            ->label('Enable Maintenance Mode')
                            ->helperText('When enabled, site will show maintenance message to visitors'),
                        
                        Forms\Components\RichEditor::make('maintenance_message')
                            ->label('Maintenance Message')
                            ->visible(fn (Forms\Get $get) => $get('maintenance_mode')),
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
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
