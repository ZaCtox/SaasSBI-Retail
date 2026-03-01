<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;


class DashboardController extends Controller
{
    public function kpis()
    {
        $totalSales = DB::table('sales')->sum('revenue');
        $totalMargin = DB::table('sales')->sum('margin');

        $topProducts = DB::table('sales')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(sales.revenue) as total_revenue'))
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

        return new DashboardResource($data);
    }
}