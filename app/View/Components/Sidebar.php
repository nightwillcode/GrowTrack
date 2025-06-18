<?php

namespace App\View\Components;

use Closure;
use App\Models\Project;
use App\Models\ProjectRole;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public $projects;
    public $ownerList;

    public function __construct()
    {
        $userId = Auth::id();

        $projectIds = ProjectRole::where('user_id', $userId)
            ->pluck('project_id');

        $this->projects = Project::whereIn('id', $projectIds)->get();

        $roleId = Role::where('name', 'owner')->value('id');
        foreach ($this->projects as $project) {
            $ownerRole = ProjectRole::where('project_id', $project->id)
                ->where('role_id', $roleId)
                ->with('user')
                ->first();

            $project->owner_name = $ownerRole?->user?->name ?? 'Unknown';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
