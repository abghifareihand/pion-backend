<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * GET /api/organizations
     */
    public function index()
    {
        $organizations = Organization::orderBy('created_at', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Organizations fetched successfully',
            'data' => $organizations->items(),
            'meta' => [
                'current_page' => $organizations->currentPage(),
                'last_page' => $organizations->lastPage(),
                'per_page' => $organizations->perPage(),
                'total' => $organizations->total(),
                'next_page_url' => $organizations->nextPageUrl(),
            ],
        ]);
    }


    /**
     * GET /api/organizations/{id}
     */
    public function show(Organization $organization)
    {
        return response()->json([
            'status' => true,
            'message' => 'Organization fetched successfully',
            'data' => $organization,
        ]);
    }
}
