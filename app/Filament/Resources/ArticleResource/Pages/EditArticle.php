<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
  protected static string $resource = ArticleResource::class;

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
    return 'Article has been updated successfully';
  }

  protected function getRedirectUrl(): string
  {
    return $this->getResource()::getUrl('index');
  }
}