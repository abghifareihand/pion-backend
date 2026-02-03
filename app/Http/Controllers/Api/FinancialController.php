<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use Illuminate\Http\Request;

class FinancialController extends Controller
{
    /**
     * GET /api/financials
     */
    public function index()
    {
        $financials = Financial::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Financials fetched successfully',
            'data' => $financials->items(),
            'meta' => [
                'current_page' => $financials->currentPage(),
                'last_page' => $financials->lastPage(),
                'per_page' => $financials->perPage(),
                'total' => $financials->total(),
                'next_page_url' => $financials->nextPageUrl(),
            ],
        ]);
    }


    /**
     * GET /api/financials/{id}
     */
    public function show(Financial $financial)
    {
        return response()->json([
            'status' => true,
            'message' => 'Financial fetched successfully',
            'data' => $financial,
        ]);
    }
}
