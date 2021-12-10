<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\IRoleRepository;

class RoleRepository extends BaseRepository implements IRoleRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
