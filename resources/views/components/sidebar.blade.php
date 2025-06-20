<aside class="w-64 bg-white dark:bg-gray-800 shadow-md min-h-screen p-4 overflow-y-auto">
    <h2 class="mb-6 text-lg font-bold text-gray-900 dark:text-white tracking-tight">
        {{ __('Projects') }}
    </h2>
        @forelse ($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}"
            class="block rounded-lg bg-gray-100 dark:bg-gray-700 mb-4 p-4 hover:bg-gray-200 dark:hover:bg-gray-600 transition duration-200 ease-in-out">
                <div class="text-gray-800 dark:text-white font-semibold truncate">
                    {{ $project->name }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-300">
                    Owner: {{ $project->owner_name ?? 'Unknown' }}
                </div>
            </a>
        @empty
            <div class="text-center text-sm text-gray-500 dark:text-gray-400 mt-4">
                Tidak ada proyek yang tersedia.
            </div>
        @endforelse
</aside>
