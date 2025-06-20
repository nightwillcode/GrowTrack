<?php

namespace App\Http\Controllers;

use App\Models\ProjectRole;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectRoleController extends Controller
{
    public function index(Request $request)
    {
        $projectId = $request->input('project_id');

        if (!$projectId) {
            abort(404, 'Project ID tidak ditemukan');
        }

        $users = User::whereNotIn('id', function ($query) use ($projectId) {
            $query->select('user_id')
                ->from('project_roles')
                ->where('project_id', $projectId);
        })->get();
        $roles = Role::where('name', '!=', 'Owner')->get();


        $projectRoles = ProjectRole::where('project_id', $projectId)
            ->with('role') // pastikan eager load role
            ->latest()
            ->get()
            ->sortBy(function ($item) {
                $order = [
                    'owner' => 1,
                    'admin' => 2,
                    'member' => 3,
                ];

                return $order[strtolower($item->role->name)] ?? 99;
            });

        return view('projectRoles.index', compact('projectRoles', 'projectId', 'users', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        ProjectRole::create($validated);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function update(Request $request, ProjectRole $projectRole)
    {
        $request->validate([
            'role' => 'required',
        ]);

        $role = Role::where('name', $request->role)->first();
        if ($role) {
            $projectRole->role_id = $role->id;
            $projectRole->save();
        }

        return back()->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(ProjectRole $projectRole)
    {
        $projectRole->delete();
        return redirect()->back()->with('success', 'Project deleted.');
    }
}
