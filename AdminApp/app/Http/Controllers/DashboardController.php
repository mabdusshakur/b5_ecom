<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $total_orders = Invoice::count();
        $total_products = Product::count();
        $total_revenue = Invoice::where('delivery_status', 'Delivered')->sum('total');
        return inertia('Dashboard',[
            'total_orders' => $total_orders,
            'total_products' => $total_products,
            'total_revenue'=> $total_revenue
        ])->withViewData('title', 'Dashboard');
    }
}
