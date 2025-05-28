<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;;
class SaleController extends Controller
{
    public function index(Request $req)
    {
        $start = $req->query('start');
        $end = $req->query('end');
        $sort = $req->query('sort', 'asc');
        $sales = Sale::with('customer:id,name', 'cashier:id,username', 'detail', 'detail.items:id,name,price,qty')->orderBy('order_date', $sort)->when($start && $end, function ($query) use ($start, $end) {
            $query->whereBetween('order_date', [$start, $end]);
        })->paginate(10);

        $cashiers = User::pluck('username', 'id');
        $customers = Customer::pluck('name', 'id');

        // dd($sales);
        // return response()->json($sales);

        // return response()->json($sales);
        return view('sale.index', compact('sales', 'cashiers', 'customers'));
    }

    public function create()
    {
        $cashiers = User::pluck('username', 'id');
        $customers = Customer::pluck('name', 'id');
        $items = Item::get();

        return view('sale.create', compact('cashiers', 'customers', 'items'));
    }


    public function addSale(SaleRequest $req)
    {
        $data = $req->only(['cart_items', 'total', 'customer_id']);

        $cartItems = json_decode($data['cart_items'], true);
        $id_qty = array_column($cartItems, 'qty', 'id');
        $itemIds = array_keys($id_qty);

        // I hate hate hate hate hate hate hate hate 
        $existingItemIds = Item::whereIn('id', $itemIds)->pluck('id')->toArray();
        $missingItems = array_diff($itemIds, $existingItemIds);

        if (!empty($missingItems)) {
            return redirect()->route('sale.create')->with('error', 'Item(s) no longer exist in inventory.');
        }

        // Work only on first run, nope its because my misconfigurations
        // $pivot = [];
        // foreach ($cartItems as $item) {
        //     $pivot[$item['id']] = ['qty' => $item['qty']];
        // }
        // Laravel pivot

        $sale = Sale::create([
            'cashier_id' => Auth::id(),
            'customer_id' => $data['customer_id']
        ]);

        $saleDetail = SaleDetail::create([
            'sale_id' => $sale->id,
            'total' => $data['total']
        ]);

        // hell with laravel pivot, i hate over-abstraction
        $pivot = [];
        foreach ($cartItems as $item) {
            $pivot[] = [
                'item_id' => $item['id'],
                'sale_detail_id' => $saleDetail->id,
                'qty' => $item['qty']
            ];
        }

        DB::table('detail_item')->insert($pivot);


        Item::decrementMany('qty', $id_qty);

        return redirect()->route('sale.index')->with('success', 'Sale ordered');
    }


    public function updateSale(Request $req)
    {
        Sale::where('id', $req->id)->update($req->only(['cashier_id', 'customer_id']));
        return redirect()->route('sale.index')->with('success', 'Sale updated');
    }

    public function deleteSale(Request $req)
    {
        Sale::where('id', $req->id)->delete();
        return redirect()->back()->with('success', 'Sale deleted');
    }

    public function generateSaleReport(Request $req)
    {
        // $sale = Sale::with('detail.items')->find($req->id);
        // dd($sale->toArray());

        $sale = Sale::with(['cashier:id,username', 'customer:id,name,email', 'detail', 'detail.items'])->where('id', $req->id)->first();
        // dd($sale);


        $sale->detail->items->map(function ($item) {
            $item->subtotal = $item->pivot->qty * $item->price ;//= ($item->price * 0.05 + $item->price);
            // $item->subtotal = $item->subtotal;
            $item->qty = $item->pivot->qty;
            // unset($item->pivot);
            return $item;
        });

        // $sale->detail->total = $total;
        //$sale->detail->total = $sale->detail->total * 0.05 + $sale->detail->total;


        // sleep(2);

        // dd($sale);
        // return response()->json($sale);
        $pdf = PDF::loadView('pdf.sale', compact('sale'));
        return $pdf->stream('Sale report.pdf');
    }
}
