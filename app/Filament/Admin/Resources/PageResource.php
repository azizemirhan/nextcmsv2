<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Pages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Page Details')
                    ->tabs([
                        // TAB 1: Basic Info
                        Forms\Components\Tabs\Tab::make('Basic Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Str::slug($state))),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'scheduled' => 'Scheduled',
                                    ])
                                    ->default('draft')
                                    ->required(),
                                
                                Forms\Components\Select::make('template')
                                    ->label('Page Type')
                                    ->options([
                                        'default' => 'Dynamic Page',
                                        'home' => 'Homepage',
                                        'about' => 'About Page',
                                        'contact' => 'Contact Page',
                                    ])
                                    ->default('default'),
                                
                                Forms\Components\Textarea::make('excerpt')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),

                        // TAB 2: SEO
                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\TextInput::make('seo_title')
                                    ->label('SEO Title')
                                    ->helperText('Optimal length: 50-60 characters')
                                    ->maxLength(60),
                                
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->helperText('Optimal length: 150-160 characters')
                                    ->rows(3)
                                    ->maxLength(160),
                                
                                Forms\Components\TagsInput::make('keywords')
                                    ->separator(','),
                                
                                Forms\Components\TextInput::make('canonical_url')
                                    ->label('Canonical URL')
                                    ->url(),
                                
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Toggle::make('allow_index')
                                            ->label('Allow Index')
                                            ->default(true),
                                        
                                        Forms\Components\Toggle::make('allow_follow')
                                            ->label('Allow Follow')
                                            ->default(true),
                                    ]),
                            ]),

                        // TAB 3: Social Media
                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\Section::make('Open Graph')
                                    ->schema([
                                        Forms\Components\TextInput::make('og_title')
                                            ->label('OG Title'),
                                        
                                        Forms\Components\Textarea::make('og_description')
                                            ->label('OG Description')
                                            ->rows(2),
                                        
                                        Forms\Components\FileUpload::make('og_image')
                                            ->label('OG Image')
                                            ->image()
                                            ->directory('og-images'),
                                    ]),
                                
                                Forms\Components\Section::make('Twitter Card')
                                    ->schema([
                                        Forms\Components\Select::make('twitter_card_type')
                                            ->label('Card Type')
                                            ->options([
                                                'summary' => 'Summary',
                                                'summary_large_image' => 'Summary Large Image',
                                            ])
                                            ->default('summary_large_image'),
                                        
                                        Forms\Components\TextInput::make('twitter_title')
                                            ->label('Twitter Title'),
                                        
                                        Forms\Components\Textarea::make('twitter_description')
                                            ->label('Twitter Description')
                                            ->rows(2),
                                        
                                        Forms\Components\FileUpload::make('twitter_image')
                                            ->label('Twitter Image')
                                            ->image()
                                            ->directory('twitter-images'),
                                    ]),
                            ]),

                        // TAB 4: Redirect
                        Forms\Components\Tabs\Tab::make('Redirect')
                            ->icon('heroicon-o-arrow-uturn-right')
                            ->schema([
                                Forms\Components\Toggle::make('enable_redirect')
                                    ->label('Enable Redirect')
                                    ->reactive(),
                                
                                Forms\Components\TextInput::make('redirect_url')
                                    ->label('Redirect URL')
                                    ->url()
                                    ->visible(fn ($get) => $get('enable_redirect')),
                                
                                Forms\Components\Select::make('redirect_type')
                                    ->label('Redirect Type')
                                    ->options([
                                        '301' => '301 Permanent',
                                        '302' => '302 Temporary',
                                    ])
                                    ->default('301')
                                    ->visible(fn ($get) => $get('enable_redirect')),
                            ]),

                        // TAB 5: Banner
                        Forms\Components\Tabs\Tab::make('Banner')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Forms\Components\Toggle::make('banner_enabled')
                                    ->label('Enable Banner')
                                    ->default(true)
                                    ->reactive(),

                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('banner_title')
                                            ->label('Banner Title'),
                                        
                                        Forms\Components\Textarea::make('banner_subtitle')
                                            ->label('Banner Subtitle')
                                            ->rows(2),

                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\FileUpload::make('banner_background_image')
                                                    ->label('Background Image')
                                                    ->image()
                                                    ->directory('banners'),

                                                Forms\Components\ColorPicker::make('banner_background_color')
                                                    ->label('Background Color'),
                                            ]),

                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\Select::make('banner_height')
                                                    ->options([
                                                        'small' => 'Small (300px)',
                                                        'medium' => 'Medium (500px)',
                                                        'large' => 'Large (700px)',
                                                        'full' => 'Full Screen',
                                                    ])
                                                    ->default('medium'),

                                                Forms\Components\Select::make('banner_text_align')
                                                    ->label('Text Alignment')
                                                    ->options([
                                                        'left' => 'Left',
                                                        'center' => 'Center',
                                                        'right' => 'Right',
                                                    ])
                                                    ->default('center'),

                                                Forms\Components\Select::make('banner_text_color')
                                                    ->label('Text Color')
                                                    ->options([
                                                        'white' => 'White',
                                                        'black' => 'Black',
                                                        '#f0f0f0' => 'Light Gray',
                                                        '#333333' => 'Dark Gray',
                                                    ])
                                                    ->allowHtml()
                                                    ->default('white'),
                                            ]),
                                        
                                        Forms\Components\TextInput::make('banner_overlay_opacity')
                                            ->label('Overlay Opacity (0.0 - 1.0)')
                                            ->numeric()
                                            ->default(0.3)
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->maxValue(1),
                                    ])
                                    ->visible(fn (Forms\Get $get) => $get('banner_enabled')),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->copyable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                    ]),
                
                Tables\Columns\TextColumn::make('template')
                    ->label('Type'),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('manage_sections')
                    ->label('Manage Sections')
                    ->icon('heroicon-o-squares-2x2')
                    ->url(fn ($record) => route('filament.admin.resources.pages.manage-sections', $record)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
            'manage-sections' => Pages\ManageSections::route('/{record}/sections'),
        ];
    }
}
