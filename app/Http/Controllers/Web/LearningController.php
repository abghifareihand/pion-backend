<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index()
    {
        $learnings = Learning::latest()->get();
        return view('pages.learnings.index', compact('learnings'));
    }

    public function create()
    {
        return view('pages.learnings.create');
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

        $filePath = $request->file('file')->store('learning', 'public');

        Learning::create([
            'title' => $request->title,
            'file_path' => $filePath,
        ]);

        return redirect()->route('learnings.create')->with('success', 'Materi belajar berhasil dibuat.');
    }

    public function show(Learning $learning)
    {
        return view('pages.learnings.show', compact('learning'));
    }

    public function edit(Learning $learning)
    {
        return view('pages.learnings.edit', compact('learning'));
    }

    public function update(Request $request, Learning $learning)
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
            Storage::disk('public')->delete($learning->file_path);
            $learning->file_path = $request->file('file')->store('learning', 'public');
        }

        $learning->title = $request->title;
        $learning->save();

        return redirect()->route('learnings.index')->with('success', 'Materi belajar berhasil diperbarui.');
    }

    public function destroy(Learning $learning)
    {
        Storage::disk('public')->delete($learning->file_path);
        $learning->delete();

        return redirect()->route('learnings.index')->with('success', 'Materi belajar berhasil dihapus.');
    }
}
