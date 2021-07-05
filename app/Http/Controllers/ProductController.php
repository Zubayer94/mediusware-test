<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        $title = $req->input('title');
        $variant = $req->input('variant');
        $price_from = $req->input('price_from');
        $price_to = $req->input('price_to');
        $date = $req->input('date');

        $products = Product::query()
            ->with([
                'productVariantPrices' => function ($query) use ($price_from, $price_to) {
                    $query->when(!empty($price_from), function ($q) use ($price_from) {
                        $q->where('price', '>=', $price_from);
                    })
                        ->when(!empty($price_to), function ($q) use ($price_to) {
                            $q->where('price', '<=', $price_to);
                        });
                },
                'productVariants' => function ($query) use ($variant) {
                    $query->when(!empty($variant), function ($q) use ($variant) {
                        $q->where('variant', $variant);
                    });
                },
            ])
            ->when(!empty($title), function ($query) use ($title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->when(!empty($date), function ($query) use ($date) {
                $query->whereDate('created_at', '=', $date);
            })

            ->paginate(5);

        $variants = ProductVariant::select('variant')->groupBy('variant')->get();

        Log::info($products);
        return view('products.index', compact('products', 'variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
