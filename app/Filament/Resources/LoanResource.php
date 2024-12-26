<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Loan;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\LoanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LoanResource\RelationManagers;

class LoanResource extends Resource
{
  protected static ?string $model = Loan::class;

  protected static ?string $navigationGroup = 'Main';
  protected static ?string $navigationIcon = 'heroicon-o-building-library';
  protected static ?string $navigationLabel = 'Loans';
  protected static ?int $navigationSort = 2;

  public static ?string $label = "Loan";

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Select::make('nasabah_id')
          ->label('Customer')
          ->relationship('nasabah', 'name')
          ->native(false)
          ->required(),
        TextInput::make('loan_amount')
          ->label('Loan Amount')
          ->inputMode('number')
          ->placeholder('Enter the loan amount')
          ->rules(['required', 'numeric'])
          ->required(),
        TextInput::make('interest_rate')
          ->label('Interest Rate')
          ->inputMode('number')
          ->placeholder('Enter the interent rate (percentage)')
          ->rules(['required', 'numeric'])
          ->required(),
        Select::make('tenor')
          ->options([
            '3' => '3 Months',
            '6' => '6 Months',
            '12' => '12 Months',
            '18' => '18 Months',
            '24' => '24 Months',
          ])
          ->native(false)
          ->rules(['required'])
          ->required(),
        DateTimePicker::make('loan_disbursement_date')
          ->label('Loan Disbursement Date')
          ->rules(['required'])
          ->required(),
        Select::make('status_loan')
          ->label('Status')
          ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
          ])
          ->rules(['required'])
          ->native(false)
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->emptyStateHeading('No loans yet')
      ->emptyStateIcon('heroicon-o-banknotes')
      ->emptyStateDescription('Once you add loan, it will appear here.')
      ->columns([
        TextColumn::make('nasabah.name')
          ->label('Customer')
          ->searchable(),
        TextColumn::make('loan_amount')
          ->label('Loan Amount')
          ->money('IDR', locale: 'id'),
        TextColumn::make('interest_rate')
          ->label('Interest Rate')
          ->formatStateUsing(fn($state) => fmod($state, 1) == 0 ? (int) $state . '%' : number_format($state, 2) . '%'),
        TextColumn::make('tenor')
          ->formatStateUsing(function ($state) {
            return $state . " Months";
          }),
        TextColumn::make('loan_disbursement_date')
          ->label('Loan Disbursement Date')
          ->dateTime(),
        TextColumn::make('status_loan')
          ->label('Status')
          ->badge()
          ->icon(fn(string $state): string => match ($state) {
            'pending' => 'heroicon-o-clock',
            'approved' => 'heroicon-o-check-circle',
            'completed' => 'heroicon-o-currency-dollar',
          })
          ->formatStateUsing(fn(string $state): string => ucwords(strtolower($state)))
          ->color(fn(string $state): string => match ($state) {
            'pending' => 'warning',
            'approved' => 'success',
            'completed' => 'success',
          }),
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
        Tables\Filters\TrashedFilter::make(),
        SelectFilter::make('status_loan')
          ->label('Status')
          ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'completed' => 'Completed',
          ])
      ])
      ->filtersTriggerAction(
        fn(Action $action) => $action
          ->button()
          ->label('Filter'),
      )
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->successNotificationTitle('Loan has been deleted successfully'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make()
            ->successNotificationTitle('Loan has been deleted successfully'),
          Tables\Actions\ForceDeleteBulkAction::make()
            ->successNotificationTitle('Loan has been deleted permanently'),
          Tables\Actions\RestoreBulkAction::make()
            ->successNotificationTitle('Loan has been restored successfully'),
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
      'index' => Pages\ListLoans::route('/'),
      'create' => Pages\CreateLoan::route('/create'),
      'edit' => Pages\EditLoan::route('/{record}/edit'),
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
