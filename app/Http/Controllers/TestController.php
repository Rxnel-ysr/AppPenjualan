<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        dd(Item::incrementMany('qty', [1 => 5, 2 => 5]));
    }
}
