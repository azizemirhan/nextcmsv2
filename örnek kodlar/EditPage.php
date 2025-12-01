<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use App\Modules\Cms\Models\PageSection;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Filament\Notifications\Notification;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('manage_sections')
                ->label('Manage Sections')
                ->icon('heroicon-o-squares-2x2')
                ->url(fn () => PageResource::getUrl('sections', ['record' => $this->record]))
                ->color('primary'),

            Actions\ViewAction::make()
                ->label('Preview')
                ->url(fn () => route('page.show', $this->record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye'),

            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->submit(null)
                ->action('save'),
            $this->getCancelFormAction(),
        ];
    }
}
