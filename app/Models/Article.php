<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
  protected $guarded = ['id'];

  public function getRouteKeyName(): string
  {
    return 'slug';
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo(Category::class)->withTrashed();
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }
}
