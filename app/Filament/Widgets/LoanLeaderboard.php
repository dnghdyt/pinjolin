<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Nasabah;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LoanLeaderboard extends BaseWidget
{
  protected static ?int $sort = 4;
  public function table(Table $table): Table
  {
    $data = Nasabah::withSum('loan', 'loan_amount')
      ->orderByDesc('loan_sum_loan_amount')->take(5);
    return $table
      ->paginated(false)
      ->query($data)
      ->columns([
        TextColumn::make('index')
          ->label('Rank')
          ->rowIndex(),
        TextColumn::make('name')->label('Customer'),
        TextColumn::make('loan_sum_loan_amount')->label('Total Loan')
          ->money('IDR', locale: 'id')
          ->getStateUsing(fn($record) => $record->loan_sum_loan_amount ?? 0)
      ]);
  }
}
