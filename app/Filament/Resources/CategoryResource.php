<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CategoryResource\RelationManagers;

class CategoryResource extends Resource
{
  protected static ?string $model = Category::class;

  protected static ?string $navigationIcon = 'heroicon-o-bookmark';
  protected static ?string $navigationGroup = 'Blog';
  protected static ?int $navigationSort = 3;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('category_name')
          ->placeholder('Enter the category name')
          ->required()
          ->maxLength(255)
          ->unique(ignoreRecord: true)
          ->rules(['required'])
          ->columnSpanFull(),
        Forms\Components\Textarea::make('description')
          ->required()
          ->columnSpanFull()
          ->autosize()
          ->maxLength(255)
          ->placeholder('Enter a description category. Max (255)')
          ->rows(5)
          ->rules(['required']),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->emptyStateHeading('No categories yet')
      ->emptyStateIcon('heroicon-o-bookmark')
      ->emptyStateDescription('Once you write your first category, it will appear here.')
      ->columns([
        Tables\Columns\TextColumn::make('category_name')
          ->label('Category Name')
          ->searchable(),
        Tables\Columns\TextColumn::make('description')
          ->label('Description')
          ->limit(80)
          ->searchable(),
        Tables\Columns\TextColumn::make('deleted_at')
          ->label('Deleted At')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('created_at')
          ->label('Created At')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        Tables\Columns\TextColumn::make('updated_at')
          ->label('Updated At')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->defaultSort('created_at', 'desc')
      ->searchPlaceholder('Search categories...')
      ->filters([
        Tables\Filters\TrashedFilter::make(),
      ])
      ->filtersTriggerAction(
        fn(Action $action) => $action
          ->button()
          ->label('Filter'),
      )
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->successNotificationTitle('Category has been deleted successfully'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make()
            ->successNotificationTitle('Category has been deleted successfully'),
          Tables\Actions\ForceDeleteBulkAction::make()
            ->successNotificationTitle('Category has been deleted permanently'),
          Tables\Actions\RestoreBulkAction::make()
            ->successNotificationTitle('Category has been restored successfully'),
        ]),
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
      'index' => Pages\ListCategories::route('/'),
      'create' => Pages\CreateCategory::route('/create'),
      'edit' => Pages\EditCategory::route('/{record}/edit'),
    ];
  }

  public static function getEloquentQuery(): Builder
  {
    return parent::getEloquentQuery()
      ->withoutGlobalScopes([
        SoftDeletingScope::class,
      ]);
  }
}
