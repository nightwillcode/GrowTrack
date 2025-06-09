<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Timer extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'task_id',
        'user_id',
        'started_at',
        'stopped_at',
        'duration',
    ];

    protected static function booted(): void
    {
        static::saving(function ($timer) {
            if ($timer->started_at && $timer->stopped_at) {
                $startedAt = $timer->started_at instanceof Carbon
                    ? $timer->started_at
                    : Carbon::parse($timer->started_at);

                $stoppedAt = $timer->stopped_at instanceof Carbon
                    ? $timer->stopped_at
                    : Carbon::parse($timer->stopped_at);

                $timer->duration = $startedAt->diffInSeconds($stoppedAt);
            }
        });

        static::creating(function ($task) {
            if (!$task->id) {
                $task->id = (string) Str::uuid();
            }
        });
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
