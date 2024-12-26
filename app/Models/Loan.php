<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
  use SoftDeletes;
  protected $guarded = ['id'];

  public function nasabah(): BelongsTo
  {
    return $this->belongsTo(Nasabah::class);
  }

  public function payment(): HasMany
  {
    return $this->hasMany(Payment::class);
  }
}
