<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    public function index()
    {
        $financials = Financial::latest()->get();
        return view('pages.financials.index', compact('financials'));
    }

    public function create()
    {
        return view('pages.financials.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf|max:10240',
            ],
            [
                'title.required' => 'Judul wajib diisi.',
                'title.max' => 'Judul maksimal 255 karakter.',
                'file.required' => 'File PDF wajib diunggah.',
                'file.mimes' => 'File harus berupa PDF.',
                'file.max' => 'File maksimal 10MB.',
            ]
        );

        $filePath = $request->file('file')->store('financial', 'public');

        Financial::create([
            'title' => $request->title,
            'file_path' => $filePath,
        ]);

        return redirect()->route('financials.create')->with('success', 'Laporan keuangan berhasil dibuat.');
    }

    public function show(Financial $financial)
    {
        return view('pages.financials.show', compact('financial'));
    }

    public function edit(Financial $financial)
    {
        return view('pages.financials.edit', compact('financial'));
    }

    public function update(Request $request, Financial $financial)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'file.mimes' => 'File harus berupa PDF.',
            'file.max' => 'File maksimal 10MB.',
        ]);

        if ($request->hasFile('file')) {
            // hapus file lama
            Storage::disk('public')->delete($financial->file_path);
            $financial->file_path = $request->file('file')->store('financial', 'public');
        }

        $financial->title = $request->title;
        $financial->save();

        return redirect()->route('financials.index')->with('success', 'Laporan keuangan berhasil diperbarui.');
    }

    public function destroy(Financial $financial)
    {
        Storage::disk('public')->delete($financial->file_path);
        $financial->delete();

        return redirect()->route('financials.index')->with('success', 'Laporan keuangan berhasil dihapus.');
    }
}
