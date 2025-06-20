<x-app-layout>
    <x-slot name="sidebar">
        <x-sidebar />
    </x-slot>
    <div class="max-w-[85rem] mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-end gap-4 sm:gap-6 my-4">
            <div onclick="window.location.href='{{ route('projectRoles.index') }}?project_id={{ $project->id }}'"
                class="w-full sm:w-auto sm:max-w-xs border border-gray-300 rounded-lg bg-white p-4 cursor-pointer hover:bg-gray-100 transition">
                Manage Users
            </div>

            <div onclick="window.location.href='{{ route('tasks.create') }}'"
                class="w-full sm:w-auto sm:max-w-xs border border-gray-300 rounded-lg bg-white p-4 cursor-pointer hover:bg-gray-100 transition">
                New Tasks
            </div>
        </div>

        <div class="w-full border border-gray-300 rounded-lg bg-white p-6">
            <div class="basis-[70%] flex justify-between items-center gap-6">
                <div class="text-gray-900 dark:text-gray-100 font-bold text-xl">
                    {{ $project->name }}
                </div>
                <div class="flex items-center gap-6 text-sm text-gray-700 dark:text-gray-300">
                    <div>
                        <span class="font-semibold">User:</span> {{ $projectRole->count() }}
                    </div>
                    <div>
                        <span class="font-semibold">Task:</span> {{ $tasks->count() }}
                    </div>
                </div>
            </div>
            <div class="mt-4 text-justify">
                {{ $project->description }}
            </div>
        </div>

        <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse ($tasks as $task)
                <div class="w-full border border-{{ $task->status->color }}-300 rounded-lg bg-white p-6 mt-8">
                    <div class="basis-[70%] flex justify-between items-center gap-6">
                        <div>
                            <div class="text-gray-900 dark:text-gray-100 font-bold text-base">
                                {{ $project->name }}
                            </div>
                            <div class="text-{{ $task->status->color }}-600">
                                {{ $task->status->name }}
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 text-right">
                            👤 Willy
                        </div>
                    </div>
                    <div class="mt-4 text-justify text-sm">
                        {{ $task->description }}
                    </div>
                </div>
            @empty
                <div class="w-full border border-dashed border-gray-300 rounded-lg bg-white p-6 mt-8 text-center text-gray-500">
                    Tidak ada task untuk ditampilkan.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
