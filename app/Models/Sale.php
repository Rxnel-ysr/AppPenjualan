<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $able = 'sales';
    protected $fillable = [
        'cashier_id',
        'customer_id',
        'order_date',
];
    public $timestamps = false;

    public function detail(){
        return $this->hasOne(SaleDetail::class,'sale_id','id');
    }

    public function cashier(){
        return $this->belongsTo(User::class, 'cashier_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
