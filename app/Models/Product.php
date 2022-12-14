<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id_product';
    protected $guarded = 'id_product';
    protected $fillable = ['product_name', 'picture', 'product_description', 'reference', 'price', 'weight', 'product_category_id', 'stock', 'product_slug'];

    public function category(){
        return $this->belongsTo(Category::class, 'product_category_id');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'product_id');
    }
}
