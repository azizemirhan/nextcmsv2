<?php

namespace App\Filament\Admin\Resources\PageResource\Pages;

use App\Filament\Admin\Resources\PageResource;
use App\Models\PageSection;
use App\Models\SectionTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ManageSections extends Page implements HasForms
{
    use InteractsWithForms;
    use InteractsWithRecord;

    protected static string $resource = PageResource::class;
    protected static string $view = 'filament.admin.resources.page-resource.pages.manage-sections';
    protected static ?string $title = 'Manage Page Sections';
    
    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
        
        // Convert existing sections to Builder format
        $sections = $this->record->sections()
            ->orderBy('order')
            ->get()
            ->map(function ($section) {
                return [
                    'type' => $section->section_key,
                    'data' => array_merge(
                        [
                            'section_key' => $section->section_key,
                            'is_active' => $section->is_active,
                        ],
                        $section->content ?? []
                    ),
                ];
            })
            ->toArray();

        $this->form->fill([
            'sections' => $sections,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model($this->getRecord())
            ->schema([
                Forms\Components\Builder::make('sections')
                    ->label('Page Sections')
                    ->blocks($this->getSectionBlocks())
                    ->blockNumbers(false)
                    ->reorderable(true)
                    ->collapsible()
                    ->collapsed()
                    ->cloneable()
                    ->addActionLabel('Add Section')
                    ->columnSpanFull()
                    ->live(),
            ])
            ->statePath('data');
    }

    protected function getSectionBlocks(): array
    {
        $sectionTypes = config('sections', []);
        $blocks = [];

        foreach ($sectionTypes as $key => $config) {
            $blocks[$key] = Forms\Components\Builder\Block::make($key)
                ->label($config['name'] ?? $key)
                ->icon($config['icon'] ?? 'heroicon-o-squares-2x2')
                ->schema($this->generateFieldsForSection($key, $config['fields'] ?? []));
        }

        return $blocks;
    }

    protected function generateFieldsForSection(string $sectionKey, array $fields): array
    {
        $components = [];

        $components[] = Forms\Components\Hidden::make('section_key')
            ->default($sectionKey);

        $components[] = Forms\Components\Toggle::make('is_active')
            ->label('Active')
            ->default(true)
            ->inline(false);

        foreach ($fields as $field) {
            $component = $this->createFieldComponent($field);
            if ($component) {
                $components[] = $component;
            }
        }

        return $components;
    }

    protected function createFieldComponent(array $field): ?Forms\Components\Component
    {
        $name = $field['name'];
        $type = $field['type'] ?? 'text';
        $translatable = $field['translatable'] ?? false;

        // For translatable fields, create tabs for each language
        if ($translatable) {
            $languages = config('app.locales', ['en' => 'English', 'tr' => 'Türkçe']);

            return Forms\Components\Tabs::make($field['label'] ?? $field['name'])
                ->tabs(collect($languages)->map(function ($label, $locale) use ($field, $name, $type) {
                    return Forms\Components\Tabs\Tab::make($label)
                        ->schema([
                            $this->createSingleFieldComponent(
                                $name . '.' . $locale,
                                $field,
                                $type
                            )->label($field['label'] ?? $field['name']),
                        ]);
                })->toArray());
        }

        return $this->createSingleFieldComponent($name, $field, $type);
    }

    protected function createSingleFieldComponent(string $name, array $field, string $type): Forms\Components\Component
    {
        $label = $field['label'] ?? ucfirst(str_replace('_', ' ', $field['name']));
        $required = $field['required'] ?? false;
        $help = $field['help'] ?? null;

        $component = match($type) {
            'text' => Forms\Components\TextInput::make($name)->maxLength(255),
            'textarea' => Forms\Components\Textarea::make($name)->rows(3)->maxLength(1000),
            'file' => Forms\Components\FileUpload::make($name)->image()->directory('sections')->preserveFilenames(),
            'select' => Forms\Components\Select::make($name)->options($field['options'] ?? []),
            'checkbox' => Forms\Components\Toggle::make($name)->default($field['default'] ?? false),
            'number' => Forms\Components\TextInput::make($name)->numeric(),
            'color' => Forms\Components\ColorPicker::make($name),
            'iconpicker' => Forms\Components\TextInput::make($name)->helperText('Icon class (e.g., fas fa-star)'),
            'repeater' => Forms\Components\Repeater::make($name)
                ->schema($this->generateRepeaterFields($field['fields'] ?? []))
                ->collapsible()
                ->reorderable()
                ->defaultItems(0),
            'date' => Forms\Components\DatePicker::make($name),
            'url' => Forms\Components\TextInput::make($name)->url()->maxLength(255),
            default => Forms\Components\TextInput::make($name),
        };

        $component->label($label);
        if ($required) $component->required();
        if ($help) $component->helperText($help);
        
        // Handle default value if not repeater (repeater defaultItems handles it)
        if ($type !== 'repeater' && isset($field['default'])) {
            $component->default($field['default']);
        }

        return $component;
    }

    protected function generateRepeaterFields(array $fields): array
    {
        $components = [];

        foreach ($fields as $field) {
            $name = $field['name'];
            $type = $field['type'] ?? 'text';
            $translatable = $field['translatable'] ?? false;

            if ($translatable) {
                $languages = config('app.locales', ['en' => 'English', 'tr' => 'Türkçe']);

                $components[] = Forms\Components\Tabs::make($field['label'] ?? $name)
                    ->tabs(collect($languages)->map(function ($label, $locale) use ($field, $name, $type) {
                        return Forms\Components\Tabs\Tab::make($label)
                            ->schema([
                                $this->createSingleFieldComponent(
                                    $name . '.' . $locale,
                                    $field,
                                    $type
                                )->label($field['label'] ?? $name),
                            ]);
                    })->toArray())
                    ->columnSpanFull();
            } else {
                $components[] = $this->createSingleFieldComponent($name, $field, $type);
            }
        }

        return $components;
    }

    public function save(): void
    {
        $data = $this->form->getState();
        
        // Delete existing sections
        $this->record->sections()->delete();

        // Create new sections from builder data
        if (!empty($data['sections'])) {
            foreach ($data['sections'] as $index => $sectionData) {
                $sectionKey = $sectionData['data']['section_key'] ?? $sectionData['type'];
                $isActive = $sectionData['data']['is_active'] ?? true;

                // Extract content fields (all fields except section_key and is_active)
                $content = collect($sectionData['data'])
                    ->except(['section_key', 'is_active'])
                    ->toArray();

                PageSection::create([
                    'page_id' => $this->record->id,
                    'section_key' => $sectionKey,
                    'content' => $content,
                    'order' => $index,
                    'is_active' => $isActive,
                ]);
            }
        }
        
        \Filament\Notifications\Notification::make()
            ->title('Sections updated successfully')
            ->success()
            ->send();
    }
}
