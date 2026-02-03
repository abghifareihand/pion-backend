<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Information;
use App\Models\Learning;
use App\Models\Organization;
use App\Models\Social;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalInformations = Information::count();
        $totalLearnings = Learning::count();
        $totalFinancials = Financial::count();
        $totalOrganizations = Organization::count();
        $totalSocials = Social::count();
        $totalVotes = Vote::count();

        return view('pages.dashboard', compact(
            'totalUsers',
            'totalInformations',
            'totalLearnings',
            'totalFinancials',
            'totalOrganizations',
            'totalSocials',
            'totalVotes'
        ));
    }
}
