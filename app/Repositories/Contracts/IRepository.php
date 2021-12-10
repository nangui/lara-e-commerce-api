<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function all(array $columns = ['*'], array $relations = []): Collection;
    public function allTrashed(): Collection;
    public function findById(int $id, array $columns = ['*'], array $relations = [], $appends= []): ?Model;
    public function findTrashedById(int $id): ?Model;
    public function findOnlyTrashedById(int $id): ?Model;
    public function create(array $payload): ?Model;
    public function update(int $id, array $payload): bool;
    public function deleteById(int $id): bool;
    public function restoreById(int $id): bool;
    public function permanentlyDeleteById(int $id): bool;
    public function count(): int;
    public function paginate(array $columns = ['*'], array $relations = [], $orderColumn = 'id', $perPage = 10): LengthAwarePaginator;
}
