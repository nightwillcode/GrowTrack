<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Status extends Model
{
    protected $table = 'status';

    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'color',
        'description',
    ];

    protected static function booted(): void
    {
        static::creating(function ($task) {
            if (!$task->id) {
                $task->id = (string) Str::uuid();
            }
        });
    }
}
