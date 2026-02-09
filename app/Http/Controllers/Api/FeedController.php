<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Information;
use App\Models\Social;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * GET /api/feed
     */
    public function index()
    {
        // Ambil semua data dari tabel feed (exclude 'information')
        $inforamtions = Information::all();
        $financials = Financial::all();
        $socials = Social::all();

        // Gabungkan semua collection
        $feedItems = $inforamtions->merge($financials)->merge($socials)
            ->sortByDesc('created_at') // urut latest
            ->take(10); // ambil 10 terakhir

        // Map field untuk response
        $data = $feedItems->map(function ($item) {
            return [
                'id' => $item->id,
                'type' => $item->type, // penting untuk auto routing mobile
                'title' => $item->title,
                'created_at' => $item->created_at,
                'image_url' => $item->image_path ? asset('storage/' . $item->image_path) : null,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Feed fetched successfully',
            'data' => $data,
        ]);
    }
}
