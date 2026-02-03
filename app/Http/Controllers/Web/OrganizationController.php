<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->get();
        return view('pages.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('pages.organizations.create');
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

        $filePath = $request->file('file')->store('organization', 'public');

        Organization::create([
            'title' => $request->title,
            'file_path' => $filePath,
        ]);

        return redirect()->route('organizations.create')->with('success', 'Struktur organisasi berhasil dibuat.');
    }

    public function show(Organization $organization)
    {
        return view('pages.organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        return view('pages.organizations.edit', compact('organization'));
    }

    public function update(Request $request, Organization $organization)
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
            Storage::disk('public')->delete($organization->file_path);
            $organization->file_path = $request->file('file')->store('organization', 'public');
        }

        $organization->title = $request->title;
        $organization->save();

        return redirect()->route('organizations.index')->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    public function destroy(Organization $organization)
    {
        Storage::disk('public')->delete($organization->file_path);
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Struktur organisasi berhasil dihapus.');
    }
}
