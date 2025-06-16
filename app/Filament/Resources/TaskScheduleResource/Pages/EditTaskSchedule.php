<?php

namespace App\Filament\Resources\TaskScheduleResource\Pages;

use App\Filament\Resources\TaskScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaskSchedule extends EditRecord
{
    protected static string $resource = TaskScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
