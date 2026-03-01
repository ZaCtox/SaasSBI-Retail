<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Http\Resources\DashboardResource;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function kpis(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        $data = $this->dashboardService->getKpis($year, $month);

        return new DashboardResource($data);
    }
}