<x-app-layout>
    <div class="max-w-[85rem] mx-auto sm:px-6 lg:px-8">
        <div class="font-bold text-xl p-6 text-gray-900 dark:text-gray-100">
            Task Dashboard
        </div>
        <div class="grid sm:grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach ($tasks as $task)
                <div class="w-full border border-gray-300 rounded-lg bg-white p-6">
                    <div class="basis-[70%] flex justify-between items-center gap-6">
                        <div class="text-gray-900 dark:text-gray-100 font-bold text-xl">
                            {{ $task->name }}
                        </div>
                        <div class="basis-[30%] text-right">
                            <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                                @csrf
                                <select name="status_id" onchange="this.form.submit()"
                                    class="pr-8 py-1 rounded-md border text-sm font-medium
                                        text-{{ $task->status->color }}-600
                                        bg-{{ $task->status->color }}-100
                                        dark:bg-{{ $task->status->color }}-900
                                        dark:text-white
                                        border-{{ $task->status->color }}-300
                                        focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    @foreach ($allStatuses as $status)
                                        <option class="text-{{$status->color}}-600" value="{{ $status->id }}"
                                            @selected($task->status_id == $status->id)>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
