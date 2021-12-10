<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IRepository;
use http\Exception\InvalidArgumentException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->query()->with($relations)->get($columns);
    }

    public function allTrashed(): Collection
    {
        return $this->model->query()->onlyTrashed()->get();
    }

    public function findById(int $id, array $columns = ['*'], array $relations = [], $appends = []): ?Model
    {
        return $this->model->query()->select($columns)->with($relations)->findOrFail($id)->append($appends);
    }

    public function findTrashedById(int $id): ?Model
    {
        return $this->model->query()->withTrashed()->findOrFail($id);
    }

    public function findOnlyTrashedById(int $id): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($id);
    }

    public function create(array $payload): ?Model
    {
        $model = $this->model->query()->create($payload);
        return $model->fresh();
    }

    public function update(int $id, array $payload): bool
    {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    public function deleteById(int $id): bool
    {
        return $this->findById($id)->delete();
    }

    public function restoreById(int $id): bool
    {
        return $this->findOnlyTrashedById($id)->restore();
    }

    public function permanentlyDeleteById(int $id): bool
    {
        return $this->findTrashedById($id)->forceDelete();
    }

    public function count(): int
    {
        return $this->model->query()->count();
    }

    public function paginate(array $columns = ['*'], array $relations = [], $orderColumn = 'id', $perPage = 10): LengthAwarePaginator
    {
        return $this->model->query()->with($relations)->orderByDesc($orderColumn)->paginate($perPage, $columns);
    }
}
