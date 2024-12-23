<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    // Menampilkan semua mahasiswa
    public function index()
    {
        // return Mahasiswa::all();

        // Error Handling
        try {
            return Mahasiswa::all();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }

    // Menyimpan data mahasiswa baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|unique:mahasiswas|max:255',
            'fakultas' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'prodi' => 'required|string|max:255',
        ]);

        $mahasiswa = Mahasiswa::create($validatedData);
        return response()->json($mahasiswa, 201);
    }

    // Menampilkan mahasiswa berdasarkan ID
    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        return response()->json($mahasiswa);
    }

    // Memperbarui data mahasiswa
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $validatedData = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'nim' => 'sometimes|required|string|max:255|unique:mahasiswas,nim,' . $mahasiswa->id,
            'fakultas' => 'sometimes|required|string|max:255',
            'alamat' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'prodi' => 'sometimes|required|string|max:255',
        ]);

        $mahasiswa->update($validatedData);
        return response()->json($mahasiswa);
    }

    // Menghapus data mahasiswa
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();
        return response()->json(null, 204);
    }
}
