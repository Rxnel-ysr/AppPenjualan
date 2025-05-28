<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $req)
    {

        $name = $req->query('name');
        $address = $req->query('address');

        $customers = Customer::when($name, function ($query) use ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        })->when($address, function ($query) use ($address) {
            $query->where('address', 'like', '%' . $address . '%');
        })->paginate(10);

        return view('customer.index', compact('customers'));
    }

    public function addCustomer(CustomerRequest $req)
    {
        Customer::create($req->only([
            'name',
            'email',
            'gender',
            'address',
            'telephone'
        ]));

        return back()->with('success', 'Customer added');
    }

    public function updateCustomer(CustomerRequest $req)
    {
        Customer::where('id', $req->id)->update($req->only([
            'name',
            'email',
            'gender',
            'address',
            'telephone'
        ]));
        return back()->with('success', 'Customer data updated');
    }

    public function deleteCustomer(Request $req)
    {
        Customer::where('id', $req->id)->delete();
        return back()->with('success', 'Customer data deleted');
    }
}
