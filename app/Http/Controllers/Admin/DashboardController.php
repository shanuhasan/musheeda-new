<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DashboardStatsService;

class DashboardController extends Controller
{
    protected $statsService;

    public function __construct(DashboardStatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    public function index()
    {
        $metrics = $this->statsService->getMetrics();
        $recent = $this->statsService->getRecentData();

        return view('admin.dashboard', compact('metrics', 'recent'));
    }
}
