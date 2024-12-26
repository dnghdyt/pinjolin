<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nasabah extends Model
{
  protected $guarded = ['id'];

  public function loan(): HasMany
  {
    return $this->hasMany(Loan::class);
  }
}
