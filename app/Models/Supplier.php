<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'address',
        'post_code'
    ];
    public $timestamps = true;


    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'supplier_id');
    }
}
