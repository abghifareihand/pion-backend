<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }


    public function index()
    {
        $informations = Information::latest()->get();
        return view('pages.informations.index', compact('informations'));
    }

    public function create()
    {
        return view('pages.informations.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'title' => 'required|string|max:255',
    //             'file' => 'required|file|mimes:pdf|max:10240',
    //         ],
    //         [
    //             'title.required' => 'Judul wajib diisi.',
    //             'title.max' => 'Judul maksimal 255 karakter.',
    //             'file.required' => 'File PDF wajib diunggah.',
    //             'file.mimes' => 'File harus berupa PDF.',
    //             'file.max' => 'File maksimal 10MB.',
    //         ]
    //     );

    //     $filePath = $request->file('file')->store('information', 'public');

    //     Information::create([
    //         'title' => $request->title,
    //         'file_path' => $filePath,
    //     ]);

    //     return redirect()->route('informations.create')->with('success', 'Informasi berhasil dibuat.');
    // }

    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
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

        $filePath = $request->file('file')->store('information', 'public');

        $information = Information::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
        ]);

        // ---------- KIRIM NOTIF KE SEMUA USER ----------
        $tokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

        if (!empty($tokens)) {
            $this->firebase->sendToTokens(
                $tokens,
                'Informasi', // TITLE
                $information->title // BODY
            );
        }

        return redirect()->route('informations.index')->with('success', 'Informasi berhasil dibuat dan notifikasi dikirim.');
    }

    public function show(Information $information)
    {
        return view('pages.informations.show', compact('information'));
    }

    public function edit(Information $information)
    {
        return view('pages.informations.edit', compact('information'));
    }

    public function update(Request $request, Information $information)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'file.mimes' => 'File harus berupa PDF.',
            'file.max' => 'File maksimal 10MB.',
        ]);

        if ($request->hasFile('file')) {
            // hapus file lama
            Storage::disk('public')->delete($information->file_path);
            $information->file_path = $request->file('file')->store('information', 'public');
        }

        $information->title = $request->title;
        $information->description = $request->description;
        $information->save();

        return redirect()->route('informations.index')->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(Information $information)
    {
        Storage::disk('public')->delete($information->file_path);
        $information->delete();

        return redirect()->route('informations.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
