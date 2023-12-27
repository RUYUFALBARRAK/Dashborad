<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogsResource\Pages;
use App\Filament\Resources\BlogsResource\RelationManagers;
use App\Models\Blogs;

use App\Models\Category;
use Filament\Forms\Set;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


$user = auth()->user();


class BlogsResource extends Resource
{
    protected static ?string $model = Blogs::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Blogs';

    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Card::make()
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(2048)
                        ->live()
                         ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(2048),
                    Forms\Components\FileUpload::make('thumbnail'),
                    Forms\Components\RichEditor::make('body')
                        ->required(),
                    Forms\Components\TextInput::make('meta_title')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('meta_description')
                        ->maxLength(255),
                    Forms\Components\Toggle::make('active')
                        ->required(),
                    Forms\Components\DateTimePicker::make('published_at'),
                    Forms\Components\Select::make('categories')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        //->getSearchResultsUsing(fn (string $search) => Category::where('title', 'like', "%{$search}%")->limit(50))
                ])
                ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\ImageColumn::make('thumbnail'),
            Tables\Columns\TextColumn::make('title')->searchable(['title', 'body'])->sortable(),
            Tables\Columns\IconColumn::make('active')
                ->sortable()
                ->boolean(),
            Tables\Columns\TextColumn::make('published_at')
                ->sortable()
                ->dateTime(),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime(),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}

public static function getRelations(): array
{
    return [
        //
    ];
}

public static function getPages(): array
{
    return [
        'index' => Pages\ListBlogs::route('/'),
        'create' => Pages\CreateBlogs::route('/create'),
        'edit' => Pages\EditBlogs::route('/{record}/edit'),
    ];
}
}