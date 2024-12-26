<?php

namespace App\Filament\Resources\NasabahResource\Pages;

use App\Filament\Resources\NasabahResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNasabah extends CreateRecord
{
  protected static string $resource = NasabahResource::class;
  protected function getCreatedNotificationTitle(): ?string
  {
    return 'Customer has been created successfully';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}
