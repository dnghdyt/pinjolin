<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Nasabah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\NasabahResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\NasabahResource\RelationManagers;
use Illuminate\Database\Eloquent\Model;

class NasabahResource extends Resource
{
  protected static ?string $model = Nasabah::class;
  protected static ?string $slug = 'customers';

  protected static ?string $navigationIcon = 'heroicon-o-user-group';
  protected static ?string $navigationGroup = 'Main';
  protected static ?string $navigationLabel = 'Customers';
  protected static ?int $navigationSort = 1;
  public static ?string $label = "Customer";
  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')
          ->label('Name')
          ->placeholder('Enter the name')
          ->maxLength(100)
          ->rules(['required'])
          ->required(),
        TextInput::make('phone_number')
          ->label('Phone')
          ->tel()
          ->telRegex('/^(\+62|62|0)[2-9][0-9]{7,12}$/')
          ->unique(ignoreRecord: true)
          ->placeholder('Enter the phone')
          ->rules(['required', 'max:15'])
          ->required(),
        TextInput::make('email')
          ->label('Email')
          ->unique(ignoreRecord: true)
          ->placeholder('Enter the email')
          ->rules(['required', 'email'])
          ->required(),
        TextInput::make('id_card_number')
          ->label('ID Card Number')
          ->unique(ignoreRecord: true)
          ->inputMode('numeric')
          ->placeholder('Enter the id card number')
          ->rules(['required', 'numeric', 'digits:16'])
          ->required(),
        Textarea::make('address')
          ->label('Address')
          ->rows(5)
          ->autosize()
          ->maxLength(255)
          ->columnSpanFull()
          ->placeholder('Enter your address. Max (255)')
          ->rules(['required'])
          ->required(),
        Select::make('gender')
          ->options([
            'male' => 'Male',
            'female' => 'Female',
          ])
          ->native(false)
          ->rules(['required'])
          ->required(),
        DatePicker::make('date_of_birth')
          ->label('Date of Birth')
          ->rules(['required'])
          ->required(),
        FileUpload::make('id_card')
          ->label('ID Card')
          ->image()
          ->imageEditor()
          ->imageEditorMode(2)
          ->imageCropAspectRatio('16:9')
          ->required(),
        FileUpload::make('selfie')
          ->label('Selfie')
          ->image()
          ->imageEditor()
          ->imageEditorMode(2)
          ->imageCropAspectRatio('1:1')
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->emptyStateHeading('No customers yet')
      ->emptyStateIcon('heroicon-o-user-group')
      ->emptyStateDescription('Once you add your customer, it will appear here.')
      ->columns([
        TextColumn::make('name')
          ->searchable(),
        TextColumn::make('email')
          ->searchable(),
        TextColumn::make('phone_number')
          ->label('Phone')
          ->searchable(),
        TextColumn::make('id_card_number')
          ->label('ID Card Number')
          ->searchable(),
        TextColumn::make('gender')
          ->label('Gender')
          ->alignment(Alignment::Center)
          ->badge()
          ->formatStateUsing(fn(string $state): string => ucwords(strtolower($state)))
          ->color(fn(string $state): string => match ($state) {
            'female' => 'warning',
            'male' => 'info',
          })
          ->searchable(),
        TextColumn::make('date_of_birth')
          ->label('Date of Birth')
          ->date()
          ->searchable(),
        TextColumn::make('address'),
        ImageColumn::make('id_card')
          ->label('ID Card')
          ->height(40)
          ->alignment(Alignment::Center),
        ImageColumn::make('selfie')
          ->label('Selfie')
          ->height(40)
          ->alignment(Alignment::Center),
        TextColumn::make('created_at')
          ->label('Created At')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
        TextColumn::make('updated_at')
          ->label('Updated At')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->defaultSort('created_at', 'desc')
      ->searchPlaceholder('Search customer...')
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->successNotificationTitle('Customer has been deleted successfully'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make()
            ->successNotificationTitle('Customer has been deleted successfully'),
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
      'index' => Pages\ListNasabahs::route('/'),
      'create' => Pages\CreateNasabah::route('/create'),
      'edit' => Pages\EditNasabah::route('/{record}/edit'),
    ];
  }
}
