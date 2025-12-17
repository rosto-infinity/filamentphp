<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    // Rediriger vers la liste après modification (optionnel mais propre)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    // Notification personnalisée en cas de succès
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Utilisateur mis à jour avec succès !';
    }
}
