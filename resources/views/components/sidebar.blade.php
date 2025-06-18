<aside class="w-64 bg-white dark:bg-gray-800 shadow-md min-h-screen p-4">
    <h2 class="mb-4 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Projects') }}
    </h2>
        @forelse ($projects as $project)
            <a href="{{ route('projects.show', $project->id) }}"
            class="block border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 mb-4 p-4 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                <div class="text-gray-700 dark:text-gray-300 font-medium">
                    {{ $project->name }}
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Owner: {{ $project->owner_name ?? 'Unknown' }}
                </div>
            </a>
        @empty
            <div class="text-center text-gray-500 dark:text-gray-400 mt-4">
                Tidak ada proyek yang tersedia.
            </div>
        @endforelse
</aside>
