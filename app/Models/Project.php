<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    // UUID setup
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignable fields
    protected $fillable = [
        'name',
        'description',
    ];

    // Auto-generate UUID for 'id' when creating
    protected static function booted(): void
    {
        static::creating(function (self $project) {
            if (empty($project->id)) {
                $project->id = (string) Str::uuid();
            }
        });
    }

    public function projectRoles()
    {
        return $this->hasMany(ProjectRole::class);
    }

    public function owner()
    {
        $ownerRoleId = Role::where('name', 'owner')->value('id');

        return $this->hasOne(ProjectRole::class)->where('role_id', $ownerRoleId)->with('user');
    }
}
