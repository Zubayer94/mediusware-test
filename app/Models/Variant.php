<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'title', 'description'
    ];

    public function ProductVariantPrice()
    {
        return $this->belongsTo('App\Models\ProductVariantPrice');
    }
}
