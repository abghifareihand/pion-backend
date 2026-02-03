<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{

    public function index()
    {
        $votes = Vote::withCount('options')->latest()->get();
        return view('pages.votes.index', compact('votes'));
    }

    public function create()
    {
        $users = User::where('role', 'user')
            ->orderBy('name', 'asc') // urutkan A-Z
            ->get();

        return view('pages.votes.create', compact('users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'exists:users,id',
            'period' => 'required|string',
        ], [
            'title.required' => 'Judul voting wajib diisi.',
            'title.max' => 'Judul voting maksimal 255 karakter.',
            'options.required' => 'Minimal pilih 2 kandidat.',
            'options.array' => 'Format kandidat tidak valid.',
            'options.min' => 'Voting harus memiliki minimal 2 kandidat.',
            'options.*.exists' => 'Salah satu kandidat tidak ditemukan.',
            'period.required' => 'Periode voting wajib diisi.',
        ]);

        [$start, $end] = explode(' - ', $request->period);

        $startAt = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
        $endAt   = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();

        DB::transaction(function () use ($request, $startAt, $endAt) {

            $vote = Vote::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_at' => $startAt,
                'end_at' => $endAt,
                'is_active'   => true
            ]);

            foreach ($request->options as $userId) {
                $user = User::find($userId);

                $vote->options()->create([
                    'user_id' => $user->id,
                    'label' => $user->name,
                ]);
            }
        });

        return redirect()->route('votes.create')->with('success', 'Voting berhasil dibuat.');
    }

    public function show(Vote $vote)
    {
        // load options urut A-Z berdasarkan label (nama kandidat)
        $vote->load(['options' => function ($query) {
            $query->orderBy('label', 'asc');
        }]);

        return view('pages.votes.show', compact('vote'));
    }

    public function edit(Vote $vote)
    {
        // Load vote + options A-Z
        $vote->load(['options' => function ($query) {
            $query->orderBy('label', 'asc');
        }]);

        return view('pages.votes.edit', compact('vote'));
    }

    public function update(Request $request, Vote $vote)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'period' => 'required|string',
            'is_active' => 'nullable|boolean',
        ], [
            'title.required' => 'Judul voting wajib diisi.',
            'title.max' => 'Judul voting maksimal 255 karakter.',
            'period.required' => 'Periode voting wajib diisi.',
        ]);

        [$start, $end] = explode(' - ', $request->period);

        $startAt = Carbon::createFromFormat('d/m/Y', $start)->startOfDay();
        $endAt   = Carbon::createFromFormat('d/m/Y', $end)->endOfDay();

        $vote->update([
            'title' => $request->title,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'is_active' => (bool)$request->is_active,

        ]);

        return redirect()->route('votes.edit', $vote->id)->with('success', 'Voting berhasil diperbarui.');
    }


    public function destroy(Vote $vote)
    {
        $vote->options()->delete();
        $vote->delete();
        return redirect()->route('votes.index')->with('success', 'Voting berhasil dihapus.');
    }
}
