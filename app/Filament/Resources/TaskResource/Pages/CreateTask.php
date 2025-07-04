<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika visible_at tidak dikirim dari form, isi manual
        if (!isset($data['visible_at'])) {
            $data['visible_at'] = now(); // atau Carbon::now()
        }

        return $data;
    }
}
