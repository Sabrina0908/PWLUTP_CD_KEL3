<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas: {{ $task->title }}</title>
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
        <h1 class="text-2xl font-extrabold text-yellow-600 border-b pb-3 mb-6">Edit Tugas: {{ $task->title }}</h1>

        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
                <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                @error('title')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="priority_id" class="block text-sm font-medium text-gray-700 mb-1">Prioritas</label>
                <select id="priority_id" name="priority_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">-- Pilih Prioritas --</option>
                    @foreach ($priorities as $id => $name)
                        <option value="{{ $id }}" {{ old('priority_id', $task->priority_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('priority_id')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Notes)</label>
                <textarea id="notes" name="notes" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 resize-y">{{ old('notes', $task->notes) }}</textarea>
                @error('notes')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>
            
            <!-- Checkbox Status Selesai -->
            <div class="mb-6 flex items-center space-x-2">
                <!-- Hidden field ini memastikan nilai 'false' terkirim jika checkbox TIDAK dicentang -->
                <input type="hidden" name="is_completed" value="0">
                <input type="checkbox" id="is_completed" name="is_completed" value="1" {{ old('is_completed', $task->is_completed) ? 'checked' : '' }} class="h-4 w-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                <label for="is_completed" class="text-sm font-medium text-gray-700">Sudah Selesai</label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700 transition duration-150">
                    Perbarui Tugas
                </button>
            </div>
        </form>
    </div>
</body>
>>>>>>> b437715 (ini ketinggalan kemarin lupa gk ke push)
</html>