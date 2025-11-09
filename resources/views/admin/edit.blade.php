<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Prioritas - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'], }, } } }
    </script>
</head>
<body class="bg-gray-50 font-sans p-4 sm:p-8">
    <div class="max-w-lg mx-auto bg-white shadow-xl rounded-xl p-6 lg:p-8">
        <h1 class="text-2xl font-bold text-yellow-600 border-b pb-3 mb-5">Edit Prioritas: {{ $priority->name }}</h1>

        <form action="{{ route('priorities.update', $priority) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Prioritas</label>
                <input type="text" id="name" name="name" value="{{ old('name', $priority->name) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                @error('name')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label for="color_code" class="block text-sm font-medium text-gray-700 mb-1">Kode Warna (Hex)</label>
                <div class="flex items-center space-x-3">
                    <input type="color" id="color_code_picker" value="{{ old('color_code', $priority->color_code) }}" onchange="document.getElementById('color_code').value = this.value;" class="p-0 h-10 w-10 border-none rounded-md cursor-pointer">
                    <input type="text" id="color_code" name="color_code" value="{{ old('color_code', $priority->color_code) }}" maxlength="7" placeholder="#007bff" required class="flex-grow px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                </div>
                @error('color_code')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 transition duration-150">
                    Perbarui Prioritas
                </button>
            </div>
        </form>
    </div>
</body>
</html>