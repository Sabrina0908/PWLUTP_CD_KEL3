<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas Baru</title>
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
</head>
<body class="bg-gray-50 font-sans p-4 sm:p-8">
    <div class="max-w-xl mx-auto bg-white shadow-xl rounded-xl p-6 lg:p-8">
        <h1 class="text-2xl font-extrabold text-green-600 border-b pb-3 mb-6">Tambah Tugas Baru</h1>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                @error('title')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="priority_id" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                <select id="priority_id" name="priority_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">-- Pilih Prioritas --</option>
                    @foreach ($priorities as $id => $name)
                        <option value="{{ $id }}" {{ old('priority_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('priority_id')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
            
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Notes)</label> 
                <textarea id="notes" name="notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 resize-y">{{ old('notes') }}</textarea>
                @error('notes')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition duration-150">
                    Simpan Tugas
                </button>
            </div>
        </form>
    </div>
</body>
>>>>>>> b437715 (ini ketinggalan kemarin lupa gk ke push)
</html>