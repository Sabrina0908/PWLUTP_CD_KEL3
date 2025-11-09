<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Priority; // WAJIB: Import Model Priority

class DashboardController extends Controller
{
    /**
     * Memuat dashboard yang sesuai berdasarkan role user.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // --- LOGIKA UNTUK ADMIN ---
            $tasks = Task::with(['user', 'priority'])
                     ->orderBy('created_at', 'desc')
                     ->get();
            // Ambil semua Prioritas untuk ditampilkan di dashboard admin
            $priorities = Priority::withCount('tasks')->get();
                     
            return view('admin.dashboard', compact('tasks', 'priorities'));
        }
        
        // --- LOGIKA UNTUK USER BIASA ---
        // Ambil tugas milik user yang sedang login
        $tasks = $user->tasks()->with('priority')
                 ->orderBy('is_completed', 'asc') 
                 ->orderBy('created_at', 'desc')
                 ->get();

        return view('user.dashboard', compact('tasks'));
    }
}