<?php

namespace App\Filament\Pages\Settings;

use App\Services\Settings\SettingsService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class MailSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?string $navigationLabel = 'Mail Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.settings.mail-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = app(SettingsService::class);
        $this->form->fill([
            'mail_from_address' => $settings->get('mail_from_address', config('mail.from.address')),
            'mail_from_name' => $settings->get('mail_from_name', config('mail.from.name')),
            'mail_contact_recipient' => $settings->get('mail_contact_recipient'),
            'mail_notification_recipient' => $settings->get('mail_notification_recipient'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Mail Configuration')
                    ->description('Configure email settings for your site')
                    ->schema([
                        Forms\Components\TextInput::make('mail_from_address')
                            ->label('From Email Address')
                            ->email()
                            ->required()
                            ->helperText('Default sender email address'),
                        
                        Forms\Components\TextInput::make('mail_from_name')
                            ->label('From Name')
                            ->required()
                            ->helperText('Default sender name'),
                    ]),

                Forms\Components\Section::make('Recipients')
                    ->description('Configure where emails should be sent')
                    ->schema([
                        Forms\Components\TextInput::make('mail_contact_recipient')
                            ->label('Contact Form Recipient')
                            ->email()
                            ->required()
                            ->helperText('Email address to receive contact form submissions'),
                        
                        Forms\Components\TextInput::make('mail_notification_recipient')
                            ->label('Notification Recipient')
                            ->email()
                            ->helperText('Email address to receive system notifications'),
                    ]),

                Forms\Components\Section::make('Test Email')
                    ->description('Send a test email to verify configuration')
                    ->schema([
                        Forms\Components\Placeholder::make('test_info')
                            ->content('Use the button below to send a test email and verify your mail configuration is working correctly.'),
                        
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('send_test_email')
                                ->label('Send Test Email')
                                ->color('primary')
                                ->action(function () {
                                    // TODO: Implement test email functionality
                                    Notification::make()
                                        ->title('Test email sent')
                                        ->body('Check your inbox for the test email')
                                        ->success()
                                        ->send();
                                }),
                        ]),
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
            ->title('Mail settings saved successfully')
            ->success()
            ->send();
    }
}
