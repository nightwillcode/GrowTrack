<?php

namespace App\Filament\Resources\ProjectRoleResource\Pages;

use App\Filament\Resources\ProjectRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectRoles extends ListRecords
{
    protected static string $resource = ProjectRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
