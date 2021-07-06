<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductApiController extends Controller
{
    public function storeProducts(Request $request)
    {
        $product_variants = $request->input('product_variant');
        $product_variant_prices = $request->input('product_variant_prices');

        $product = Product::create([
            'title' => $request->input('title'),
            'sku' => $request->input('sku'),
            'description' => $request->input('description')
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'file_path' => $request->input('product_image'),
            'thumbnail' => 1
        ]);

        foreach ($product_variants as $key => $variants) {
            foreach ($variants['tags'] as $key => $tag) {
                ProductVariant::create([
                    'variant' => $tag,
                    'variant_id' => $variants['option'],
                    'product_id' => $product->id,
                ]);
            }
        }

        return response()->json(['message' => 'success'], 200);
    }
    public function uploadImage(Request $request)
    {

        // $photos = $request->file('file');

        // if (!is_array($photos)) {
        //     $photos = [$photos];
        // }

        // for ($i = 0; $i < count($photos); $i++) {
        //     $photo = $photos[$i];

        //     $imageName =  time() . '.' . $image->extension();
        //     $photo->move(public_path('images'), $imageName);
        // }

        $image = $request->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);
        return response()->json(['message' => 'success', 'images' => $imageName]);
    }
}
