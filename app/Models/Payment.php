<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
  protected $guarded = ['id'];

  public function loan(): BelongsTo
  {
    return $this->belongsTo(Loan::class)->withTrashed();
  }

  protected static function booted()
  {
    static::created(function ($payment) {
      $loan = $payment->loan;

      $totalPaid = $loan->payment()->sum('amount');

      $totalAmountDue = $loan->loan_amount + ($loan->loan_amount * $loan->interest_rate / 100);

      if ($totalPaid >= $totalAmountDue) {
        $loan->update(['status_loan' => 'completed']);
      }
    });

    static::deleted(function ($payment) {
      $loan = $payment->loan;

      $totalPaid = $loan->payment()->sum('amount');

      $totalAmountDue = $loan->loan_amount + ($loan->loan_amount * $loan->interest_rate / 100);

      if ($totalPaid <= $totalAmountDue) {
        $loan->update(['status_loan' => 'approved']);
      }
    });
  }
}
