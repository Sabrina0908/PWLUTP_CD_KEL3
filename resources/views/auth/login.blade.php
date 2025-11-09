<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - To Do List App</title>
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
<body class="bg-gray-100 font-sans flex justify-center items-center min-h-screen p-4">

    <div class="bg-white p-8 sm:p-10 rounded-xl shadow-2xl w-full max-w-sm">
        <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">Masuk ke Aplikasi</h2>
        
        <!-- Notifikasi/Pesan Error -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-5" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Formulir Login -->
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-150">
            </div>

            <button type="submit" 
                class="w-full py-2.5 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-150 text-lg">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-5">
            Belum punya akun? <a href="{{ route('auth.showRegisterForm') }}" class="text-blue-600 hover:text-blue-800 font-medium transition duration-150">Daftar di sini</a>
        </p>
    </div>

</body>
</html>