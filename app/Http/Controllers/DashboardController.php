<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $items = Item::where('qty', '<=', '10')->paginate(10);
        // dd(empty($items));
        return view('dashboard.index', compact('items'));
    }
}
