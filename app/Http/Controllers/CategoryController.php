<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ICategoryRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private ICategoryRepository $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->categoryRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = $this->categoryRepository->create([
            'name' => $request->get('name'),
            'slug' => Str::slug((string)$request->get('name'))
        ]);

        return response($category, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $category = $this->categoryRepository->findById($id);

        return response($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, ['name' => 'required']);

        $result = $this->categoryRepository->update($id, $request->only('name') + [
            'slug' => Str::slug($request->get('name'))
        ]);

        return response($result, Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->categoryRepository->deleteById($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
