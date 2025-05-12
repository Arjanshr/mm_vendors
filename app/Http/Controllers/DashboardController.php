<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Spatie\Activitylog\Models\Activity; // Import Spatie's Activity model
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count();
        $orderCount = Order::count();
        $totalRevenue = Order::sum('grand_total');
        $pendingOrderCount = Order::where('status', 'pending')->count();
        $recentOrders = Order::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        $recentProducts = Product::with('variants')->latest()->take(5)->get();
        $activities = Activity::latest()->take(10)->get(); // Fetch the latest 10 activities

        return view('admin.dashboard', compact(
            'userCount',
            'orderCount',
            'totalRevenue',
            'pendingOrderCount',
            'recentOrders',
            'recentUsers',
            'recentProducts',
            'activities'
        ));
    }

    public function test()
    {
        return User::with('roles')->get();
    }
}
