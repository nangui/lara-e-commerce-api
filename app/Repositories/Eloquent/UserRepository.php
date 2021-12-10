<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\IUserRepository;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements IUserRepository
{
    const NAME_COLUMN = 'name';
    const ADMIN = 'Admin';
    const EDITOR = 'Editor';
    const VIEWER = 'Viewer';

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function fetchAdmins(): Collection
    {
        return $this->model->query()->where(self::NAME_COLUMN, self::ADMIN)->get();
    }

    public function fetchEditors(): Collection
    {
        return $this->model->query()->where(self::NAME_COLUMN, self::EDITOR)->get();
    }

    public function fetchViewers(): Collection
    {
        return $this->model->query()->where(self::NAME_COLUMN, self::VIEWER)->get();
    }
}
