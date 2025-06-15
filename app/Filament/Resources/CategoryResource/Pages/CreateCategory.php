<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('cancel')
                ->label('Cancel')
                ->color('secondary')
                ->outlined()
                ->url($this->getResource()::getUrl('index')),
            Action::make('save')
                ->label('Save')
                ->submit('save')
                ->color('primary')
                ->action(function () {
                    $this->save();
                }),
        ];
    }
}
