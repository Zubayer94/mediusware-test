<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::select('variant')->groupBy('variant')->get();
        return $variants;
    }
}
