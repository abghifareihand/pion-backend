<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * GET /api/informations
     */
    public function index()
    {
        $socials = Social::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Socials fetched successfully',
            'data' => $socials->items(),
            'meta' => [
                'current_page' => $socials->currentPage(),
                'last_page' => $socials->lastPage(),
                'per_page' => $socials->perPage(),
                'total' => $socials->total(),
                'next_page_url' => $socials->nextPageUrl(),
            ],
        ]);
    }


    /**
     * GET /api/informations/{id}
     */
    public function show(Social $social)
    {
        return response()->json([
            'status' => true,
            'message' => 'Social fetched successfully',
            'data' => $social,
        ]);
    }
}
