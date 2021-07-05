<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $products = Product::with(['productVariantPrices', 'productVariants'])->get();
        return $products;
    }
}
