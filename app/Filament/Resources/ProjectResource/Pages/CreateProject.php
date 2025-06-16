<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Project;
use App\Models\ProjectRole;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function handleRecordCreation(array $data): Project
    {
        $userId = $this->form->getRawState()['user_id'];
        $project = Project::create($data);

        // Simpan ke project_roles
        ProjectRole::create([
            'project_id' => $project->id,
            'user_id' => $userId,
            'role' => 'owner',
        ]);

        return $project;
    }
}
