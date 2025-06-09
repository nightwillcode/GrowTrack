<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'status',
        'started_at',
        'finished_at',
    ];

    protected static function booted(): void
    {
        static::creating(function ($task) {
            if (!$task->id) {
                $task->id = (string) Str::uuid();
            }
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
