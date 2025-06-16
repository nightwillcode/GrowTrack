<?php

namespace App\Filament\Resources\TaskScheduleResource\Pages;

use App\Filament\Resources\TaskScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskSchedule extends CreateRecord
{
    protected static string $resource = TaskScheduleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika visible_at tidak dikirim dari form, isi manual
        if (!isset($data['visible_at'])) {
            $data['visible_at'] = now(); // atau Carbon::now()
        }

        return $data;
    }
}
