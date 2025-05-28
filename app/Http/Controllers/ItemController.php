<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    public function index(Request $req)
    {
        $name = $req->query('name');
        $category = $req->query('category');
        $order_by = $req->query('order_by', 'created_at');
        $sort = $req->query('sort', 'desc');

        $items = Item::when($category, function ($query) use ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('id', $category);
            });
        })
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->with('category')
            ->orderBy($order_by, $sort)
            ->paginate(10);

        $categories = Category::pluck('name', 'id');

        return view('item.index', compact('items', 'categories'));
    }


    public function addItem(ItemRequest $req)
    {
        // dd('oi');
        $data = $req->only(['name', 'qty', 'price', 'category_id']);

        // if ($req->hasFile('picture')) {
        //     $pictures = [];
        //     foreach ($req->file('picture') as $pic) {
        //         $filename = Str::uuid() . '.' . $pic->getClientOriginalExtension();
        //         array_push($pictures, $pic->storeAs('pictures', $filename, 'public'));
        //     }
        //     // $file = $req->file('picture');
        //     // $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        //     $data['picture'] = implode(',', $pictures);
        // }

        if ($req->hasFile('picture')) {
            $file = $req->file('picture');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $data['picture'] = $file->storeAs('pictures', $filename, 'public');
        }

        // dd($data);

        Item::create($data);

        return redirect()->back()->with('success', 'Item created');
    }


    public function updateItem(ItemRequest $req)
    {
        $item = Item::findOrFail($req->id);

        // dd($req->all());

        if ($req->hasFile('picture')) {
            if ($item->picture && Storage::disk('public')->exists($item->picture)) {
                Storage::disk('public')->delete($item->picture);
                Storage::disk('public')->files('students');
            }
            // if ($item->picture) {
            //     foreach (explode(',', $item->picture) as $pic) {
            //         Storage::disk('public')->exists($pic) && Storage::disk('public')->delete($pic);
            //     }
            // }

            // foreach ($req->file('picture') as $pic) {
            //     $filename = Str::uuid() . '.' . $pic->getClientOriginalExtension();
            //     array_push($pictures, $pic->storeAs('pictures', $filename, 'public'));
            // }
            $file = $req->file('picture');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $item->picture = $file->storeAs('pictures', $filename, 'public');
        }

        $item->fill($req->only(['name', 'price', 'category_id']));

        // dd($item);

        if ($item->isClean()) {
            return redirect()->back()->with('info', 'No change were made');
        }

        $item->save();
        return redirect()->back()->with('success', 'Item ' . $item->name . ' updated');
    }


    public function deleteItem(Request $req)
    {
        $item = Item::findOrFail($req->id);
        if ($item->picture && Storage::disk('public')->exists($item->picture)) {
            Storage::disk('public')->delete($item->picture);
        }
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted');
    }
}
