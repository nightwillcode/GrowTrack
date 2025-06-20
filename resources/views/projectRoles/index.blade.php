<x-app-layout>
    <div x-data="modalHandler()" class="max-w-[85rem] mx-auto sm:px-6 lg:px-8">
        <!-- Tombol Tambah User -->
        <div class="flex justify-end mb-4">
            <button @click="openAddUserModal = true"
                class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white text-sm font-semibold rounded-md shadow hover:bg-green-700 transition">
                Tambah User
            </button>
        </div>

        <div x-show="openAddUserModal" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full relative">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Tambah User ke Proyek</h2>

                <form action="{{ route('projectRoles.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $projectId }}">

                    <!-- Pilih User -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">User</label>
                        <select name="user_id" id="user_id" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <option value="" disabled selected>Pilih user</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Role -->
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Role</label>
                        <select name="role_id" id="role_id" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:text-white">
                            <option value="" disabled selected>Pilih role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" @click="openAddUserModal = false"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:underline">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Daftar Project Roles -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($projectRoles as $projectRole)
                <div class="w-full border border-gray-300 rounded-lg bg-white p-6">
                    <!-- Nama & Role -->
                    <div class="flex justify-between items-center gap-6">
                        <div class="text-gray-900 dark:text-gray-100 font-bold text-base">
                            {{ $projectRole->user->name }}
                        </div>

                        <!-- Dropdown Role -->
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button @click="open = !open"
                                class="flex items-center gap-1 px-2 py-1 rounded-full text-sm font-medium
                                    {{ $projectRole->role->name === 'Owner' ? 'text-yellow-600 bg-yellow-50' :
                                       ($projectRole->role->name === 'Admin' ? 'text-blue-600 bg-blue-50' : 'text-gray-600 bg-gray-100') }}">
                                @if($projectRole->role->name === 'Owner')
                                    👑 Owner
                                @elseif($projectRole->role->name === 'Admin')
                                    🛡️ Admin
                                @else
                                    👤 Member
                                @endif
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-cloak @click.outside="open = false"
                                class="absolute z-10 mt-2 w-40 bg-white border border-gray-300 rounded shadow dark:bg-gray-800 dark:border-gray-600">
                                @foreach (['Owner' => '👑 Owner', 'Admin' => '🛡️ Admin', 'Member' => '👤 Member'] as $key => $label)
                                    @if(strtolower($projectRole->role->name) !== strtolower($key))
                                        <form method="POST" action="{{ route('projectRoles.update', $projectRole->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="role" value="{{ $key }}">
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                {{ $label }}
                                            </button>
                                        </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Created Date & Remove -->
                    <div class="flex justify-between items-center mt-4 text-sm text-gray-600 dark:text-gray-300">
                        <div>
                            Dibuat pada: {{ $projectRole->created_at->format('d M Y') }}
                        </div>
                        <button
                            @click="openModal('{{ route('projectRoles.destroy', $projectRole->id) }}', '{{ $projectRole->user->name }}')"
                            class="text-red-600 hover:text-red-800 transition flex items-center gap-1">
                            🗑️ Remove
                        </button>
                    </div>
                </div>
            @empty
                <div class="w-full border border-dashed border-gray-300 rounded-lg bg-white p-6 mt-8 text-center text-gray-500">
                    Tidak ada user dalam proyek ini.
                </div>
            @endforelse
        </div>

        <!-- Modal Global -->
        <div x-show="showModal" x-cloak
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow max-w-md w-full relative">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Konfirmasi Hapus</h2>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Apakah kamu yakin ingin menghapus <strong x-text="deletingName"></strong> dari proyek?
                </p>
                <div class="flex justify-end gap-4">
                    <button @click="showModal = false"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:underline">
                        Batal
                    </button>
                    <form :action="deletingAction" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine Modal Handler -->
    <script>
        function modalHandler() {
            return {
                showModal: false,
                openAddUserModal: false,
                deletingAction: '',
                deletingName: '',
                openModal(action, name) {
                    this.deletingAction = action;
                    this.deletingName = name;
                    this.showModal = true;
                }
            };
        }
    </script>
</x-app-layout>
