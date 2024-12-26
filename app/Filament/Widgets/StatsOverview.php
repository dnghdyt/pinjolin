<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Article;
use App\Models\Nasabah;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $totalModal = 0;
    $payments = Payment::with(['loan'])->whereDate('payment_date', Carbon::today())->get();
    foreach ($payments as $payment) {
      $modal = ceil($payment->loan->loan_amount / $payment->loan->tenor);
      $totalModal += $modal;
    }
    $paymentChange = $this->getPaymentCalculateChange();

    $nasabahData = $this->getDataForLast7Days(Nasabah::class);
    $nasabahToday = $nasabahData['today'];
    $nasabahYesterday = $nasabahData['yesterday'];
    $nasabahChart = $nasabahData['chart'];
    $nasabahChange = $this->calculateChange($nasabahYesterday, $nasabahToday);

    $loanData = $this->getDataForLast7Days(Loan::class,  [
      ['column' => 'status_loan', 'operator' => '=', 'value' => 'completed']
    ]);
    $loanChart = $loanData['chart'];

    $articlesData = $this->getDataForLast7Days(Article::class);
    $articlesChart = $articlesData['chart'];

    return [
      Stat::make('Renevue today', 'Rp ' . $this->formatCurrency($paymentChange['today']))
        ->description(abs($paymentChange['percentage']) . '% ' . (($paymentChange['status'] === 'increase')  ? 'increase today' : 'decrease today'))
        ->descriptionIcon(($paymentChange['status'] === 'increase')  ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->chart($this->getPaymentsForLast7Days())
        ->color(($paymentChange['today'] > $paymentChange['yesterday']) ? 'success' : 'danger'),

      Stat::make('Customers', Nasabah::count())
        ->description(abs($nasabahChange) . '% ' . ($nasabahChange >= 0 ? 'increase today' : 'decrease today'))
        ->descriptionIcon($nasabahChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
        ->chart($nasabahChart)
        ->color($nasabahChange >= 0 ? 'success' : 'danger'),

      Stat::make('Loans', Loan::where('status_loan', 'completed')->count())
        ->description('Loan completed')
        ->chart($loanChart)
        ->color('info'),

      Stat::make('Articles', Article::where('status', 'published')->count())
        ->description('Article published')
        ->chart($articlesChart)
        ->color('warning'),
    ];
  }

  private function getDataForLast7Days($modelClass, $additionalConditions = []): array
  {
    $query = $modelClass::query();

    if (!empty($additionalConditions)) {
      foreach ($additionalConditions as $condition) {
        $query->where($condition['column'], $condition['operator'], $condition['value']);
      }
    }

    $data = $query
      ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
      ->whereBetween('created_at', [now()->subDays(7), now()])
      ->groupBy('date')
      ->orderBy('date', 'asc')
      ->pluck('count', 'date')
      ->toArray();

    $chart = [];
    $today = now()->toDateString();
    $yesterday = now()->subDay()->toDateString();

    for ($i = 6; $i >= 0; $i--) {
      $date = now()->subDays($i)->toDateString();
      $chart[] = $data[$date] ?? 0;
    }

    return [
      'today' => $data[$today] ?? 0,
      'yesterday' => $data[$yesterday] ?? 0,
      'chart' => $chart,
    ];
  }

  private function calculateChange(int $previous, int $current): int
  {
    if ($previous === 0) {
      return $current > 0 ? 100 : 0;
    }

    return intval((($current - $previous) / $previous) * 100);
  }

  private function formatCurrency($amount)
  {
    return number_format($amount, 0, '', '.');
  }

  private function getPaymentsForLast7Days(): array
  {
    $data = [];
    for ($i = 6; $i >= 0; $i--) {
      $totalModal = 0;
      $date = Carbon::today()->subDays($i);

      $payments = Payment::with(['loan'])->whereDate('payment_date', $date)->get();
      foreach ($payments as $payment) {
        $modal = ceil($payment->loan->loan_amount / $payment->loan->tenor);
        $totalModal += $modal;
      }

      $amount = Payment::whereDate('payment_date', $date)->sum('amount') - $totalModal;
      $data[] = (string) $amount;
    }

    return $data;
  }

  private function getPaymentCalculateChange(): array
  {
    $today = Payment::with(['loan'])->whereDate('payment_date', Carbon::today())->get();
    $yesterday = Payment::with(['loan'])->whereDate('payment_date', Carbon::yesterday())->get();

    $paymentsToday = Payment::with(['loan'])->whereDate('payment_date', Carbon::today())->sum('amount');
    $paymentsYesterday = Payment::with(['loan'])->whereDate('payment_date', Carbon::yesterday())->sum('amount');

    $totalModalToday = 0;
    foreach ($today as $paymentToday) {
      $modal = ceil($paymentToday->loan->loan_amount / $paymentToday->loan->tenor);
      $totalModalToday += $modal;
    }

    $totalModalYesterday = 0;
    foreach ($yesterday as $paymentYesterday) {
      $modal = ceil($paymentYesterday->loan->loan_amount / $paymentYesterday->loan->tenor);
      $totalModalYesterday += $modal;
    }

    $renevueToday = $paymentsToday - $totalModalToday;
    $renevueYesterday = $paymentsYesterday - $totalModalYesterday;

    if ($renevueYesterday == 0) {
      $percentageChange = $renevueToday > 0 ? 100 : 0;
      $status = $renevueToday > 0 ? 'increase' : 'decrease';
    } else {
      $percentageChange = intval((($renevueToday -  $renevueYesterday) /  $renevueYesterday) * 100);
      $status = $percentageChange > 0 ? 'increase' : 'decrease';
    }

    return [
      'status' => $status,
      'percentage' => abs($percentageChange),
      'today' => $renevueToday,
      'yesterday' =>  $renevueYesterday,
    ];
  }
}
