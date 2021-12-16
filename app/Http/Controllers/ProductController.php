<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\IProductRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    const DEFAULT_COLUMN = ['*'];
    const DEFAULT_RELATIONS = ['variations'];

    private IProductRepository $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductCollection
     * @throws AuthorizationException
     */
    public function index(): ProductCollection
    {
        \Gate::authorize('view', 'products');
        $products = $this->productRepository->paginate(self::DEFAULT_COLUMN, self::DEFAULT_RELATIONS);

        return ProductCollection::make($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function store(CreateProductRequest $request): \Illuminate\Http\Response
    {
        \Gate::authorize('edit', 'products');
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
     * @throws AuthorizationException
     */
    public function show(Product $product): ProductResource
    {
        \Gate::authorize('view', 'products');
        $product->load(['category', 'variations']);

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(UpdateProductRequest $request, $id): \Illuminate\Http\Response
    {
        \Gate::authorize('edit', 'products');
        $validated = $request->validated();

        $created = $this->productRepository->update($id, $validated + [
           'slug' => $validated['title']
        ]);

        if (!$created) return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);

        return response(true, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function destroy(int $id): \Illuminate\Http\Response
    {
        \Gate::authorize('edit', 'products');
        $this->productRepository->deleteById($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
