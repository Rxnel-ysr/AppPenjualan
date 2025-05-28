<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $req)
    {
        $name = $req->query('name');
        $order_by = $req->query('order_by', 'created_at');
        $sort = $req->query('sort', 'asc');

        $suppliers = Supplier::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->orderBy($order_by, $sort)->paginate(10);

        return view('supplier.index', compact('suppliers'));
    }

    public function addSupplier(SupplierRequest $req)
    {
        Supplier::create($req->only([
            'name',
            'address',
            'post_code'
        ]));

        return back()->with('success', 'New Supplier added');
    }

    public function updateSupplier(SupplierRequest $req, Supplier $sup)
    {
        // dd($req->all());
        $newValues = $req->only([
            'name',
            'address',
            'post_code'
        ]);

        if ($req->getOldValues() == $newValues) {
            return back()->with('info', 'No change were made');
        }

        Supplier::where($sup->getKeyName(), $req->id)
            ->update($newValues);

        return back()->with('success', 'Supplier data updated');
    }


    public function deleteSupplier(Request $req, Supplier $sup)
    {
        Supplier::where($sup->getKeyName(), $req->id)->delete();
        return back()->with('success', 'Supplier data deleted');
    }
}
