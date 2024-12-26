<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
  protected static string $resource = LoanResource::class;

  protected function getCreatedNotificationTitle(): ?string
  {
    return 'Loan has been created successfully';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
