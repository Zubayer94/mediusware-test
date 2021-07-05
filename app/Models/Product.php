<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'title', 'sku', 'description'
    ];

    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }
    public function productVariantPrices()
    {
        return $this->hasMany('App\Models\ProductVariantPrice');
    }
    public function productVariants()
    {
        return $this->hasMany('App\Models\ProductVariant');
    }
    public static function varrient($id)
    {
        return $productVariant = ProductVariant::where('product_id', $id)->get();
        // dd($productVariant);
    }
    public static function varientPrices($id)
    {
        return $varientPrices = ProductVariantPrice::where('product_id', $id)->get();
        // dd($varientPrices);
    }
}
