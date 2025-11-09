<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tugas Saya</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #007bff; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .task-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .task-list { list-style: none; padding: 0; }
        .task-item { display: block; padding: 15px; margin-bottom: 10px; border-radius: 6px; background-color: #fafafa; border: 1px solid #ddd; transition: background-color 0.3s; }
        .task-item.completed { background-color: #e9ecef; opacity: 0.7; }
        .task-main-row { display: flex; justify-content: space-between; align-items: center; }
        .task-content { flex-grow: 1; display: flex; align-items: center; }
        .task-title { font-weight: bold; font-size: 1.1em; margin-right: 15px; }
        .task-item.completed .task-title { text-decoration: line-through; }
        .task-priority { font-size: 0.85em; padding: 4px 8px; border-radius: 4px; color: white; margin-left: 10px; }
        .task-notes { font-size: 0.9em; color: #666; margin-top: 5px; padding-left: 35px; } /* Jarak untuk notes */
        .actions { display: flex; gap: 8px; }
        .actions button, .actions a { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; color: white; font-size: 0.9em; }
        .btn-edit { background-color: #ffc107; }
        .btn-delete { background-color: #dc3545; }
        .btn-primary { background-color: #007bff; }
    </style>
</head>
<body>
    <div style="text-align: right; margin-bottom: 20px; padding: 10px 0;">
        <span style="font-weight: bold; margin-right: 15px;">Halo, {{ Auth::user()->name }} (User)!</span>
        <form action="{{ route('auth.logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: 1px solid #dc3545; color: #dc3545; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Logout</button>
        </form>
    </div>
    
    <div class="container">
        <div class="task-header">
            <h1>Daftar Tugas Saya</h1>
            <a href="{{ route('tasks.create') }}" class="btn-primary" style="padding: 10px 15px;">+ Tambah Tugas Baru</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">{{ session('error') }}</div>
        @endif

        <ul class="task-list">
            @forelse ($tasks as $task)
                <li class="task-item {{ $task->is_completed ? 'completed' : '' }}">
                    <div class="task-main-row">
                        <div class="task-content">
                            <!-- Toggle Status -->
                            <form action="{{ route('tasks.toggleComplete', $task) }}" method="POST" style="margin-right: 15px;">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background: none; border: 1px solid #ccc; border-radius: 50%; width: 24px; height: 24px; cursor: pointer; display: flex; justify-content: center; align-items: center; color: transparent;">
                                    @if ($task->is_completed)
                                        <span style="color: #28a745;">✓</span>
                                    @endif
                                </button>
                            </form>
                            
                            <span class="task-title">{{ $task->title }}</span>
                            
                            <!-- Prioritas -->
                            @if ($task->priority)
                                <span class="task-priority" style="background-color: {{ $task->priority->color_code ?? '#6c757d' }};">
                                    {{ $task->priority->name }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="actions">
                            <!-- Edit -->
                            <a href="{{ route('tasks.edit', $task) }}" class="btn-edit">Edit</a>
                            
                            <!-- Hapus -->
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Catatan (Notes) - Bagian yang ditambahkan -->
                    @if ($task->notes)
                        <p class="task-notes">
                            **Catatan:** {{ $task->notes }}
                        </p>
                    @endif
                </li>
            @empty
                <p style="text-align: center; padding: 20px; background-color: #fff3cd; border-radius: 4px; color: #856404;">Anda belum memiliki tugas. Mari buat satu!</p>
            @endforelse
        </ul>

    </div>
</body>
</html>