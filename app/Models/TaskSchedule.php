<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TaskSchedule extends Model
{
    use HasFactory;

    // UUID setup
    public $incrementing = false;
    protected $keyType = 'string';

    // Mass assignable fields
    protected $fillable = [
        'project_id',
        'user_id',
        'name',
        'description',
        'visible_at',
        'frequency',
        'duration',
        'allow_saturday',
        'allow_sunday',
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

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
