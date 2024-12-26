<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class RenevueChart extends ChartWidget
{
  protected static ?int $sort = 3;
  public function getHeading(): string|Htmlable|null
  {
    return 'Renevue ' . Carbon::now()->year;
  }

  public function getDescription(): ?string
  {
    return 'Total income per month.';
  }

  protected function getData(): array
  {
    $months = [];
    for ($i = 0; $i < 12; $i++) {
      $months[] = Carbon::now()->startOfYear()->addMonths($i)->format('M');
    }
    return [
      'datasets' => [
        [
          'label' => 'Renevue',
          'data' => $this->getPaymentsForLast12Months(),
        ],
      ],
      'labels' => $months,
    ];
  }

  protected function getType(): string
  {
    return 'line';
  }

  private function getPaymentsForLast12Months(): array
  {
    $data = [];
    for ($i = 11; $i >= 0; $i--) {
      $totalModal = 0;
      $startOfMonth = Carbon::today()->subMonths($i)->startOfMonth();
      $endOfMonth = Carbon::today()->subMonths($i)->endOfMonth();

      $payments = Payment::with(['loan'])
        ->whereBetween('payment_date', [$startOfMonth, $endOfMonth])
        ->get();

      foreach ($payments as $payment) {
        $modal = ceil($payment->loan->loan_amount / $payment->loan->tenor);
        $totalModal += $modal;
      }

      $amount = Payment::whereBetween('payment_date', [$startOfMonth, $endOfMonth])
        ->sum('amount') - $totalModal;

      $data[] = (string) $amount;
    }

    return $data;
  }
}
