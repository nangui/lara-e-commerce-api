<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVariationRequest;
use App\Http\Requests\UpdateVariationRequest;
use App\Http\Resources\VariationCollection;
use App\Http\Resources\VariationResource;
use App\Models\Variation;
use App\Repositories\Contracts\IVariationRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VariationController extends Controller
{
    const DEFAULT_COLUMN = ['*'];
    const DEFAULT_RELATIONS = ['product'];

    const KEY_IMAGES = 'images';

    private IVariationRepository $variationRepository;

    public function __construct(IVariationRepository $variationRepository)
    {
        $this->variationRepository = $variationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return VariationCollection
     * @throws AuthorizationException
     */
    public function index(): VariationCollection
    {
        \Gate::authorize('view', 'products');
        $variations = $this->variationRepository->paginate(self::DEFAULT_COLUMN, self::DEFAULT_RELATIONS);

        return VariationCollection::make($variations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateVariationRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function store(CreateVariationRequest $request)
    {
        \Gate::authorize('edit', 'products');
        $payload = $request->all();

        $variation = $this->variationRepository->create($payload);

        if ($variation) return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);

        if ($request->hasFile(self::KEY_IMAGES)) {
            foreach ($request->file(self::KEY_IMAGES) as $file) {
                $variation->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection(self::KEY_IMAGES);
            }
        }

        return response(VariationResource::make($variation), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function show(int $id): \Illuminate\Http\Response
    {
        \Gate::authorize('view', 'products');
        $variation = $this->variationRepository->findById($id, self::DEFAULT_COLUMN, self::DEFAULT_RELATIONS);

        return response(VariationResource::make($variation));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVariationRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function update(UpdateVariationRequest $request, int $id): \Illuminate\Http\Response
    {
        \Gate::authorize('edit', 'products');
        $created = $this->variationRepository->update($id, $request->only(
            'product_id',
            'us_size',
            'euro_size',
            'uk_size',
            'color_name',
            'color_code',
            'price'
        ));

        if (!$created) return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);


        if ($request->hasFile(self::KEY_IMAGES)) {
            $variation = $this->variationRepository->findById($id);
            $variation->clearMediaCollection(self::KEY_IMAGES);
            foreach ($request->file(self::KEY_IMAGES) as $file) {
                $variation->addMedia($file)
                    ->withResponsiveImages()
                    ->toMediaCollection(self::KEY_IMAGES);
            }
        }

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
        $this->variationRepository->deleteById($id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
