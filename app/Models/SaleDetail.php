<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = 'sale_details';
    protected $fillable = [
        'sale_id',
        'total',
    ];
    public $timestamps = false;

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }

    public function items(){
        return $this->belongsToMany(Item::class, 'detail_item', 'sale_detail_id', 'item_id')->withPivot('qty');
    }
}
