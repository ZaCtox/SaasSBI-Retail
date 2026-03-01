<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getKpis($year = null, $month = null): array
    {
        $salesBaseQuery = DB::table('sales')
            ->join('dates', 'sales.date_id', '=', 'dates.id');

        if ($year) {
            $salesBaseQuery->where('dates.year', $year);
        }

        if ($month) {
            $salesBaseQuery->where('dates.month', $month);
        }

        // Totales
        $totalSales = (clone $salesBaseQuery)->sum('sales.revenue');
        $totalMargin = (clone $salesBaseQuery)->sum('sales.margin');

        // Ticket promedio
        $transactionCount = (clone $salesBaseQuery)->count();
        $averageTicket = $transactionCount > 0 
            ? $totalSales / $transactionCount 
            : 0;

        // Top productos
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

        // Ventas mensuales
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

            // Obtener ventas agrupadas por año y mes
$monthlySalesRaw = DB::table('sales')
    ->join('dates', 'sales.date_id', '=', 'dates.id')
    ->select(
        'dates.year',
        'dates.month',
        DB::raw('SUM(sales.revenue) as total_sales')
    )
    ->groupBy('dates.year', 'dates.month')
    ->orderByDesc('dates.year')
    ->orderByDesc('dates.month')
    ->get();

// Crecimiento mensual (comparar últimos 2 meses)
$growthPercentage = 0;

if ($monthlySalesRaw->count() >= 2) {
    $current = $monthlySalesRaw[0]->total_sales;
    $previous = $monthlySalesRaw[1]->total_sales;

    if ($previous > 0) {
        $growthPercentage = (($current - $previous) / $previous) * 100;
    }
}

        return [
            'total_sales' => $totalSales,
            'total_margin' => $totalMargin,
            'average_ticket' => $averageTicket,
            'top_products' => $topProducts,
            'monthly_sales' => $monthlySales,
            'growth_percentage' => $growthPercentage
        ];
    }
}