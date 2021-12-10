<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     */
    public function index(): ProductCollection
    {
        $products = Product::query()->with('variations')->orderByDesc('id')->orderBy('title')->paginate();

        return new ProductCollection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request): \Illuminate\Http\Response
    {
        $validated = $request->validated();

        $product = Product::create($validated + [
            'slug' => Str::slug($validated['title'])
        ]);

        return response(ProductResource::make($product), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        $product->load(['category', 'variations']);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest  $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product): \Illuminate\Http\Response
    {
        $validated = $request->validated();

        $product->update($validated + [
            'slug' => $validated['title']
        ]);

        return response(ProductResource::make($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product): \Illuminate\Http\Response
    {
        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
