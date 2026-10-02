<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::query()->with('items')->latest()->paginate(15),
        ]);
    }
}