<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'status' => 'success',
            'data' => [
                'total_sales' => $this['total_sales'],
                'total_margin' => $this['total_margin'],
                'average_ticket' => $this['average_ticket'],
                'top_products' => $this['top_products'],
                'monthly_sales' => $this['monthly_sales'],
            ]
        ];
    }
}