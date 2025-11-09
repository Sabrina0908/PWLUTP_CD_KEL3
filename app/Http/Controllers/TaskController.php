<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Helper: Mengecek apakah pengguna adalah Admin.
     */
    protected function isAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    // Metode INDEX() DIHAPUS karena logikanya sudah dipindahkan ke DashboardController::index()

    /**
     * Menampilkan formulir untuk membuat tugas baru.
     */
    public function create()
    {
        $priorities = Priority::pluck('name', 'id');
        // Redirect ke dashboard setelah membuat, karena index tidak ada
        return view('tasks.create', compact('priorities'));
    }

    /**
     * Menyimpan tugas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'priority_id' => ['nullable', 'exists:priorities,id'], 
        ]);

        Task::create([
            'user_id' => Auth::id(), 
            'title' => $request->title,
            'notes' => $request->notes,
            'priority_id' => $request->priority_id,
        ]);

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit tugas.
     */
    public function edit(Task $task)
    {
        // Otorisasi: Jika bukan Admin DAN bukan pemilik, tolak akses.
        if (!$this->isAdmin() && Auth::id() !== $task->user_id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke tugas ini.');
        }

        $priorities = Priority::pluck('name', 'id');
        return view('tasks.edit', compact('task', 'priorities'));
    }

    /**
     * Memperbarui tugas di database.
     */
    public function update(Request $request, Task $task)
    {
        // Otorisasi
        if (!$this->isAdmin() && Auth::id() !== $task->user_id) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'priority_id' => ['nullable', 'exists:priorities,id'],
            'is_completed' => 'sometimes|boolean',
        ]);

        $task->update($request->all());

        // Redirect Admin kembali ke dashboard admin, dan User ke dashboard user
        if ($this->isAdmin()) {
             return redirect()->route('dashboard')->with('success', 'Tugas pengguna berhasil diperbarui.');
        }

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Menghapus tugas dari database.
     */
    public function destroy(Task $task)
    {
        // Otorisasi
        if (!$this->isAdmin() && Auth::id() !== $task->user_id) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $task->delete();
        
        // Redirect Admin kembali ke dashboard admin, dan User ke dashboard user
        if ($this->isAdmin()) {
             return redirect()->route('dashboard')->with('success', 'Tugas pengguna berhasil dihapus.');
        }

        return redirect()->route('dashboard')->with('success', 'Tugas berhasil dihapus.');
    }
    
    /**
     * Mengubah status 'is_completed' tugas (toggle).
     */
    public function toggleComplete(Task $task)
    {
        // Otorisasi
        if (!$this->isAdmin() && Auth::id() !== $task->user_id) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }

        $task->is_completed = !$task->is_completed;
        $task->save();
        
        // Redirect Admin kembali ke dashboard admin, dan User ke dashboard user
        if ($this->isAdmin()) {
             return redirect()->route('dashboard')->with('success', 'Status tugas pengguna berhasil diubah.');
        }

        return redirect()->route('dashboard')->with('success', 'Status tugas berhasil diubah.');
    }
}