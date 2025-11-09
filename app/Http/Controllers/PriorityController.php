<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    /**
     * Tampilkan formulir untuk membuat prioritas baru.
     * Tidak ada index() karena daftar sudah digabungkan ke dashboard.
     */
    public function create()
    {
        return view('admin.priority.create');
    }

    /**
     * Simpan prioritas yang baru dibuat di storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name',
            'color_code' => 'required|string|max:7',
        ]);

        Priority::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Prioritas baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan formulir untuk mengedit prioritas yang ditentukan.
     */
    public function edit(Priority $priority)
    {
        return view('admin.priority.edit', compact('priority'));
    }

    /**
     * Perbarui prioritas yang ditentukan di storage.
     */
    public function update(Request $request, Priority $priority)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name,' . $priority->id,
            'color_code' => 'required|string|max:7',
        ]);

        $priority->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Prioritas berhasil diperbarui.');
    }

    /**
     * Hapus prioritas yang ditentukan dari storage.
     */
    public function destroy(Priority $priority)
    {
        // Pencegahan: Cek apakah ada tugas yang menggunakan prioritas ini
        if ($priority->tasks()->count() > 0) {
            return redirect()->route('dashboard')->with('error', 'Tidak dapat menghapus prioritas karena masih digunakan oleh beberapa tugas.');
        }

        $priority->delete();

        return redirect()->route('dashboard')->with('success', 'Prioritas berhasil dihapus.');
    }
}