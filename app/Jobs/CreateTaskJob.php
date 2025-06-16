<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CreateTaskJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = now();
        $hourMinute = $now->format('H:i');

        // Ambil konfigurasi sesuai waktu sekarang
        $tasks = RecurringTask::where('run_at', $hourMinute)->get();

        foreach ($tasks as $task) {
            // Cek apakah harus jalan sekarang (daily / weekly)
            if (
                $task->repeat_interval === 'daily' ||
                ($task->repeat_interval === 'weekly' && $now->isMonday()) // bisa disesuaikan
            ) {
                Task::create([
                    'user_id' => $task->user_id,
                    'name' => $task->name,
                    'description' => $task->description,
                    'status' => 'pending',
                    'started_at' => now(),
                    // tambahkan kolom lain sesuai kebutuhan
                ]);
            }
        }
    }
}
