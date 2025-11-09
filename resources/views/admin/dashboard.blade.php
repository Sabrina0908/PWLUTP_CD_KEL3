<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], }, } } }
    </script>
    <style>
        .table-auto td, .table-auto th { vertical-align: top; }
        .priority-table th { background-color: #fce7f3 !important; color: #9d174d !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans p-4 sm:p-8">
    
    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 lg:p-10">
        
        <!-- Header & Salam -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4 mb-6 border-red-100">
            <h1 class="text-3xl font-extrabold text-red-700 mb-2 sm:mb-0">Dashboard Administrator</h1>
            <span class="text-lg font-semibold text-gray-700">Selamat Datang, {{ Auth::user()->name }} (Admin)!</span>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif


        <div class="flex justify-end mb-4">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 text-red-600 font-semibold border border-red-300 rounded-lg hover:bg-red-50 transition duration-150">
                    Logout
                </button>
            </form>
        </div>


        <!-- TABEL TUGAS PENGGUNA (DI ATAS) -->
        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-t pt-6">Semua Tugas Pengguna ({{ $tasks->count() }})</h2>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm mb-12">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-red-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">#ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Status Tugas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Judul Tugas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Kategori Prioritas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Catatan Detail (Notes)</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Pemilik Tugas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-red-700 uppercase tracking-wider">Tgl. Dibuat</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-red-700 uppercase tracking-wider">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600 font-medium">{{ $task->id }}</td>
                            <td class="px-4 py-3">
                                @if ($task->is_completed)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $task->title }}</td>
                            <td class="px-4 py-3">
                                @if ($task->priority)
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full text-white" style="background-color: {{ $task->priority->color_code ?? '#6b7280' }};">
                                        {{ $task->priority->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500">Tidak Ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-500 max-w-xs whitespace-normal">{{ $task->notes ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $task->user->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $task->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-col space-y-2 text-center w-full">
                                    
                                    <form action="{{ route('tasks.toggleComplete', $task) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="w-full text-xs font-semibold py-1.5 rounded-md transition duration-150 
                                            {{ $task->is_completed ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}" title="Ubah Status">
                                            {{ $task->is_completed ? 'Set Pending' : 'Set Selesai' }}
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('tasks.edit', $task) }}" class="text-xs font-semibold py-1.5 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition duration-150 w-full" title="Edit Tugas">Edit</a>
                                    
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-xs font-semibold py-1.5 rounded-md bg-red-500 text-white hover:bg-red-600 transition duration-150" title="Hapus Tugas" onclick="return confirm('Yakin hapus tugas milik {{ $task->user->name }}?');">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500 bg-gray-50">Belum ada tugas yang dibuat oleh pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- TABEL PRIORITAS (DI BAWAH) -->
        <div class="flex justify-between items-center mb-4 pt-6 border-t border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Prioritas</h2>
            <a href="{{ route('priorities.create') }}" class="px-4 py-2 bg-pink-600 text-white font-semibold rounded-lg shadow-md hover:bg-pink-700 transition duration-150 text-sm">
                + Tambah Prioritas Baru
            </a>
        </div>
        
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm table-auto">
                <thead class="bg-pink-50 priority-table">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">Nama Prioritas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">Kode Warna</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-pink-700 uppercase tracking-wider">Tugas Terkait</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-pink-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($priorities as $priority)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600 font-medium">{{ $priority->id }}</td>
                            <td class="px-4 py-3 text-gray-800 font-medium">{{ $priority->name }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block w-6 h-6 rounded-full border border-gray-300 mr-2 align-middle" style="background-color: {{ $priority->color_code ?? '#ccc' }};"></span>
                                <span class="text-gray-600 text-xs">{{ $priority->color_code }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $priority->tasks_count }} Tugas</td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('priorities.edit', $priority) }}" class="text-xs font-semibold py-1.5 px-3 rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition duration-150">Edit</a>
                                    
                                    <form action="{{ route('priorities.destroy', $priority) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold py-1.5 px-3 rounded-md bg-red-500 text-white hover:bg-red-600 transition duration-150" 
                                            onclick="return confirm('Yakin hapus prioritas {{ $priority->name }}? ({{ $priority->tasks_count }} tugas akan terpengaruh)');">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500 bg-gray-50">Belum ada data prioritas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>