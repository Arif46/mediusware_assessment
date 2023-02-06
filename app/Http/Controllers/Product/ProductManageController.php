<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Validations\Product\ProductValidation;
use App\Models\{ Product, ProductImage, ProductVariant, ProductVariantPrice };
use Illuminate\Support\Facades\DB;

class ProductManageController extends Controller
{
     /**
     * Product List.
     *
     * @return \Illuminate\View\View
    */
    public function index (Request $request)
    {
        $query = Product::with(['product_image', 'product_variants']);

        if ($request->title) {
            $query = $query->where('title', $request->title);
        }

        if ($request->sku) {
            $query = $query->where('sku', $request->sku);
        }

        if ($request->date) {
            $query = $query->whereDate('created_at', $request->date);
        }

        $list = $query->paginate($request->limit ? $request->limit : 10);

        if (!$list) {
            return response([
                'success' => false,
                'message' => "!Data Not Found",
            ]);
        } else
        {
            return response([
                'success' => true,
                'message' => "Product List Fetch Successfully",
                'data' => $list
            ]);
        }
    }
    /**
     * Product Create.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     * @return \Illuminate\Contracts\View\Factory
     * @return \Illuminate\Http\Response
     * @return \Illuminate\View\View
    */
    public function store(Request $request)
    {
        $id = $request->product_id ?? 0;
        $validationResult = ProductValidation:: validate($request, $id);

        if (!$validationResult['success']) {
            return response($validationResult);
        }

        DB::beginTransaction();

        try {

            $requestAll = $request->except(['product_image','product_variants','product_variant_prices']);

            if ($request->product_id) {

                $product = Product::find($request->product_id);
                $product->update($requestAll);

                if ($request->product_image) {
                    $productImage = $request->product_image;
                    $product->product_image()->update($productImage);
                }

                if ($request->product_variants) {
                    $productVariants = $request->product_variants;
                    $product->product_variants()->update($productVariants);
                }

                if ($request->product_variant_pricess) {
                    $productVariantsPricess = $request->product_variant_pricess;
                    $product->product_variants()->update($productVariantsPricess);
                }
            } else {

                $product = new Product();
                $application = $product->create($requestAll);

                if ($request->product_image) {
                    $product->product_image()->create($request->product_image);
                }

                if ($request->product_variants) {
                    $product->product_variants()->create($request->product_variants);
                }

                if ($request->product_variant_pricess) {
                    $product->product_variant_pricess()->create($request->product_variant_pricess);
                }
            }

            DB::commit();

            return response([
                'success' => true,
                'data' => $application,
                'message' => "Data saved successfully",
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }


}
