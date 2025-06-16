<?php

namespace App\Filament\Resources\TaskScheduleResource\Pages;

use App\Filament\Resources\TaskScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaskSchedules extends ListRecords
{
    protected static string $resource = TaskScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
