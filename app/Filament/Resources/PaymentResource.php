<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
  protected static ?string $model = Payment::class;

  protected static ?string $navigationIcon = 'heroicon-o-banknotes';
  protected static ?string $navigationGroup = 'Main';
  protected static ?string $navigationLabel = 'Payments';
  public static ?string $label = "Payment";
  protected static ?int $navigationSort = 3;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('loan_id')
          ->relationship('loan', 'id', function ($query) {
            return $query->with('nasabah')->where('status_loan', 'approved');
          })
          ->getOptionLabelFromRecordUsing(function ($record) {
            return $record->nasabah->name;
          })
          ->reactive()
          ->afterStateUpdated(function (callable $set, $state, $get) {
            $loan = \App\Models\Loan::find($get('loan_id'));
            if ($loan) {
              $calculatedAmount = ($loan->loan_amount / $loan->tenor) + ($loan->interest_rate * $loan->loan_amount / 100 / $loan->tenor);
              $set('amount',  ceil($calculatedAmount));
            }
          })
          ->rules(['required'])
          ->native(false)
          ->required(),
        Forms\Components\TextInput::make('amount')
          ->inputMode('numeric')
          ->placeholder('Enter the amount')
          ->rules(['required', 'numeric'])
          ->readOnly()
          ->required(),
        Forms\Components\DateTimePicker::make('payment_date')
          ->rules(['required'])
          ->required(),
        Select::make('payment_method')
          ->label('Payment Method')
          ->options([
            'cash' => 'Cash',
            'transfer' => 'Transfer',
          ])
          ->rules(['required'])
          ->native(false)
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->emptyStateHeading('No payments yet')
      ->emptyStateIcon('heroicon-o-credit-card')
      ->emptyStateDescription('Once you add payment, it will appear here.')
      ->columns([
        Tables\Columns\TextColumn::make('loan.nasabah.name')
          ->label('Customer')
          ->searchable(),
        Tables\Columns\TextColumn::make('amount')
          ->money('IDR', locale: 'id')
          ->searchable(),
        Tables\Columns\TextColumn::make('payment_date')
          ->label('Payment Date')
          ->searchable()
          ->dateTime(),
        Tables\Columns\TextColumn::make('payment_method')
          ->label('Method')
          ->badge()
          ->icon(fn(string $state): string => match ($state) {
            'cash' => 'heroicon-o-banknotes',
            'transfer' => 'heroicon-o-bolt',
          })
          ->alignment(Alignment::Center)
          ->searchable()
          ->color('success')
          ->formatStateUsing(fn(string $state): string => ucwords(strtolower($state))),
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
      ->searchPlaceholder('Search payments...')
      ->filters([
        // 
      ])
      ->actions([
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make()
          ->successNotificationTitle('Payment has been deleted successfully'),
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make()
            ->successNotificationTitle('Payment has been deleted successfully'),
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
      'index' => Pages\ListPayments::route('/'),
      'create' => Pages\CreatePayment::route('/create'),
      'edit' => Pages\EditPayment::route('/{record}/edit'),
    ];
  }
}
