<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tugas Saya</title>
    <!-- Memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        /* Custom styles for layout adjustments */
        .task-notes {
            padding-left: 3.5rem; /* Menjaga jarak dari checkbox */
        }
    </style>
</head>
<body class="bg-gray-50 font-sans p-4 sm:p-8">
    
    <div class="max-w-4xl mx-auto">
        
        <!-- Header & Logout -->
        <div class="flex justify-end mb-6">
            <span class="font-bold text-gray-700 mr-4">Halo, {{ Auth::user()->name }} (User)!</span>
            <form action="{{ route('auth.logout') }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="text-red-600 font-semibold border border-red-300 px-3 py-1 rounded-lg hover:bg-red-50 transition duration-150">Logout</button>
            </form>
        </div>

        <div class="bg-white shadow-xl rounded-xl p-6 lg:p-8">
            
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

            <!-- Judul & Tombol Tambah -->
            <div class="flex justify-between items-center border-b pb-4 mb-6 border-gray-100">
                <h1 class="text-3xl font-extrabold text-blue-700">Daftar Tugas Saya</h1>
                <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-150 text-sm">
                    + Tambah Tugas Baru
                </a>
            </div>

            <!-- Daftar Tugas -->
            <ul class="space-y-4">
                @forelse ($tasks as $task)
                    <li class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition duration-150 
                        {{ $task->is_completed ? 'bg-green-50/50 opacity-80' : 'bg-white' }}">
                        
                        <div class="flex justify-between items-start">
                            <!-- Konten Utama Tugas -->
                            <div class="flex-grow flex items-start space-x-3">
                                
                                <!-- Toggle Checkbox -->
                                <form action="{{ route('tasks.toggleComplete', $task) }}" method="POST" class="mt-0.5">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="h-5 w-5 border-2 rounded-full flex items-center justify-center 
                                        {{ $task->is_completed ? 'bg-green-500 border-green-500' : 'bg-white border-gray-400' }}">
                                        @if ($task->is_completed)
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 13.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </button>
                                </form>
                                
                                <div class="flex flex-col">
                                    <span class="text-lg font-semibold {{ $task->is_completed ? 'text-gray-500 line-through' : 'text-gray-800' }}">
                                        {{ $task->title }}
                                    </span>
                                    
                                    <!-- Prioritas -->
                                    @if ($task->priority)
                                        <span class="text-xs font-medium px-2 py-0.5 rounded-full text-white mt-1 w-fit" style="background-color: {{ $task->priority->color_code ?? '#6b7280' }};">
                                            {{ $task->priority->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Aksi -->
                            <div class="flex space-x-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-sm font-semibold px-3 py-1 rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition duration-150">Edit</a>
                                
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-semibold px-3 py-1 rounded-md bg-red-500 text-white hover:bg-red-600 transition duration-150" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</button>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Catatan (Notes) -->
                        @if ($task->notes)
                            <p class="task-notes text-sm text-gray-600 pt-1 mt-1 border-t border-gray-100/50">
                                <span class="font-medium text-gray-700">Catatan:</span> {{ $task->notes }}
                            </p>
                        @endif
                    </li>
                @empty
                    <p class="text-center p-6 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">Anda belum memiliki tugas. Klik "Tambah Tugas Baru" di atas!</p>
                @endforelse
            </ul>

        </div>
    </div>
</body>
</html>