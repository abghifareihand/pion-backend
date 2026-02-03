<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    /**
     * GET /api/informations
     */
    public function index()
    {
        $informations = Information::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Informations fetched successfully',
            'data' => $informations->items(),
            'meta' => [
                'current_page' => $informations->currentPage(),
                'last_page' => $informations->lastPage(),
                'per_page' => $informations->perPage(),
                'total' => $informations->total(),
                'next_page_url' => $informations->nextPageUrl(),
            ],
        ]);
    }


    /**
     * GET /api/informations/{id}
     */
    public function show(Information $information)
    {
        return response()->json([
            'status' => true,
            'message' => 'Information fetched successfully',
            'data' => $information,
        ]);
    }
}
