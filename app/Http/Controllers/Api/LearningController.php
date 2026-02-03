<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    /**
     * GET /api/learnings
     */
    public function index()
    {
        $learnings = Learning::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Learnings fetched successfully',
            'data' => $learnings->items(),
            'meta' => [
                'current_page' => $learnings->currentPage(),
                'last_page' => $learnings->lastPage(),
                'per_page' => $learnings->perPage(),
                'total' => $learnings->total(),
                'next_page_url' => $learnings->nextPageUrl(),
            ],
        ]);
    }


    /**
     * GET /api/learnings/{id}
     */
    public function show(Learning $learning)
    {
        return response()->json([
            'status' => true,
            'message' => 'Learning fetched successfully',
            'data' => $learning,
        ]);
    }
}
