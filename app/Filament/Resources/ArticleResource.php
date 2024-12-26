<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Article;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ArticleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ArticleResource\RelationManagers;

class ArticleResource extends Resource
{
  protected static ?string $model = Article::class;

  protected static ?string $navigationIcon = 'heroicon-o-newspaper';
  protected static ?string $navigationGroup = 'Blog';
  protected static ?int $navigationSort = 3;
  public static ?string $label = "Article";
  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Hidden::make('user_id')
          ->default(Auth::id()),
        TextInput::make('title')
          ->label('Title')
          ->maxLength(100)
          ->placeholder('Enter the title')
          ->rules(['required'])
          ->reactive()
          ->afterStateUpdated(function (Article $article, $state, callable $set) {
            $slug = Str::slug($state);
            $counter = 1;
            while ($article->where('slug', $slug)->exists()) {
              $slug = Str::slug($state) . '-' . $counter;
              $counter++;
            }
            $set('slug', $slug);
          })
          ->required(),
        TextInput::make('slug')
          ->label('Slug')
          ->readOnly()
          ->unique(ignoreRecord: true)
          ->placeholder('Slug is automatically filled')
          ->rules(['required'])
          ->required(),
        Textarea::make('description')
          ->rows(5)
          ->autosize()
          ->maxLength(255)
          ->columnSpanFull()
          ->rules(['required'])
          ->placeholder('Enter a description article. Max (255)')
          ->required(),
        RichEditor::make('content')
          ->disableToolbarButtons([
            'blockquote',
            'strike',
            'attachFiles'
          ])
          ->rules(['required'])
          ->required()
          ->columnSpanFull(),
        FileUpload::make('thumbnail')
          ->image()
          ->imageEditor()
          ->imageEditorMode(2)
          ->imageCropAspectRatio('16:9')
          ->columnSpanFull(),
        Select::make('status')
          ->options([
            'draft' => 'Draft',
            'published' => 'Published',
          ])
          ->rules(['required'])
          ->native(false)
          ->required(),
        Select::make('category_id')
          ->relationship('category', 'category_name')
          ->rules(['required'])
          ->native(false)
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->emptyStateHeading('No posts yet')
      ->emptyStateIcon('heroicon-o-newspaper')
      ->emptyStateDescription('Once you write your first post, it will appear here.')
      ->columns([
        TextColumn::make('title')
          ->label('Title & Description')
          ->description(fn(Article $record): string => Str::limit($record->description, 50))
          ->limit(75)
          ->searchable(),
        TextColumn::make('slug')
          ->limit(50)
          ->searchable(),
        TextColumn::make('category.category_name')
          ->badge()
          ->color('info')
          ->searchable(),
        ImageColumn::make('thumbnail')
          ->alignment(Alignment::Center)
          ->defaultImageUrl(url('/images/placeholder.webp'))
          ->height(40),
        TextColumn::make('status')
          ->badge()
          ->icon(fn(string $state): string => match ($state) {
            'draft' => 'heroicon-o-cloud-arrow-down',
            'published' => 'heroicon-o-check-circle',
          })
          ->alignment(Alignment::Center)
          ->formatStateUsing(fn(string $state): string => ucwords(strtolower($state)))
          ->color(fn(string $state): string => match ($state) {
            'draft' => 'warning',
            'published' => 'success',
          })
          ->searchable(),
        TextColumn::make('created_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->defaultSort('created_at', 'desc')
      ->searchPlaceholder('Search articles...')
      ->filters([
        SelectFilter::make('status')
          ->options([
            'draft' => 'Draft',
            'published' => 'Published',
          ]),
        SelectFilter::make('category.category_name')
          ->relationship('category', 'category_name')
      ])
      ->filtersTriggerAction(
        fn(Action $action) => $action
          ->button()
          ->label('Filter'),
      )
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->successNotificationTitle('Article has been deleted successfully'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make()
            ->successNotificationTitle('Article has been deleted successfully'),
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
      'index' => Pages\ListArticles::route('/'),
      'create' => Pages\CreateArticle::route('/create'),
      'edit' => Pages\EditArticle::route('/{record}/edit'),
    ];
  }
}
