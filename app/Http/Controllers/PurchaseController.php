<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['item','supplier'])->paginate(10);
        $suppliers = Supplier::get();
        $items = Item::get();
        // dd($items,$suppliers, $purchases);
        return view('purchase.index', compact('purchases', 'suppliers', 'items'));
    }


    public function addPurchase(PurchaseRequest $req)
    {
        $purchase = Purchase::create($req->only([
            'item_id',
            'supplier_id',
            'qty',
        ]));

        $purchase->item()->increment('qty', $req->qty);

        return redirect()->route('purchase.index')->with('success', 'Purchased!');
    }

    public function updatePurchase(PurchaseRequest $req)
    {
        $purchase = Purchase::with('item')->findOrFail($req->id);
        $lastQty = $purchase->qty;
        $newQty = $req->qty;

        $purchase->update($req->only(['item_id', 'supplier_id', 'qty']));

        if ($req->item_id == $purchase->item->id) {
            if ($lastQty < $newQty) {
                $purchase->item()->increment('qty', $newQty - $lastQty);
            } elseif ($lastQty > $newQty) {
                $purchase->item()->decrement('qty', $lastQty - $newQty);
            }
        } else {
            Item::where('id', $purchase->item->id)->decrement('qty', $lastQty);
            Item::where('id', $req->item_id)->increment('qty', $newQty);
        }

        return redirect()->route('purchase.index')->with('success', 'Purchase updated');
    }

    public function deletePurchase(Request $req)
    {
        Purchase::where('id', $req->id)->delete();
        return back()->with('success', 'Purchase data deleted');
    }
}
