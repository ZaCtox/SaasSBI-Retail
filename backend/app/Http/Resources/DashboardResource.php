<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function kpis(): JsonResponse
    {
        try {

            $totalSales = DB::table('sales')->sum('revenue');
            $totalMargin = DB::table('sales')->sum('margin');

            $topProducts = DB::table('sales')
                ->join('products', 'sales.product_id', '=', 'products.id')
                ->select(
                    'products.name',
                    DB::raw('SUM(sales.revenue) as total_revenue')
                )
                ->groupBy('products.name')
                ->orderByDesc('total_revenue')
                ->limit(5)
                ->get();

            $monthlySales = DB::table('sales')
                ->join('dates', 'sales.date_id', '=', 'dates.id')
                ->select(
                    'dates.year',
                    'dates.month',
                    DB::raw('SUM(sales.revenue) as total_sales')
                )
                ->groupBy('dates.year', 'dates.month')
                ->orderBy('dates.year')
                ->orderBy('dates.month')
                ->get();

            $data = [
                'total_sales' => $totalSales,
                'total_margin' => $totalMargin,
                'top_products' => $topProducts,
                'monthly_sales' => $monthlySales
            ];

            return response()->json([
                'status' => 'success',
                'data' => new DashboardResource($data)
            ], 200);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener KPIs',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}