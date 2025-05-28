<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'name',
        'picture',
        'qty',
        'price',
        'category_id',
    ];
    // public $timestamps = false;


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'item_id');
    }

    public function saleDetail(){
        return $this->belongsToMany(SaleDetail::class,'detail_item','item_id', 'sale_detail_id')->withPivot('qty');
    }
}
