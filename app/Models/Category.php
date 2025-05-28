<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'name'
    ];
    protected $primaryKey = 'id';
    // public $timestamps = false;


    public function items()
    {
        return $this->hasMany(Item::class,'category_id');
    }
}
