<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id_order'];
    protected $fillable = ['quantity', 'product_id', 'total'];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
