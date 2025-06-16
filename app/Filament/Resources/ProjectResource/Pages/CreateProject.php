<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\Role;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    protected function handleRecordCreation(array $data): Project
    {
        $userId = $this->form->getRawState()['user_id'];
        $project = Project::create($data);

        $role = Role::firstOrCreate(
            ['name' => 'Owner'], // cari berdasarkan name
            ['description' => 'Owner role'] // opsional, field lain saat create
        );

        // Simpan ke project_roles
        ProjectRole::create([
            'project_id' => $project->id,
            'user_id' => $userId,
            'role_id' => $role->id,
        ]);

        return $project;
    }
}
