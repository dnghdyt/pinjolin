<?php

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoan extends EditRecord
{
  protected static string $resource = LoanResource::class;

  // protected function getHeaderActions(): array
  // {
  //   return [
  //     Actions\DeleteAction::make(),
  //     Actions\ForceDeleteAction::make(),
  //     Actions\RestoreAction::make(),
  //   ];
  // }

  protected function getSavedNotificationTitle(): ?string
  {
    return 'Loan has been updated successfully';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
