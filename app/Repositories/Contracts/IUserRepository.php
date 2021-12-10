<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface IUserRepository extends IRepository
{
    public function fetchAdmins(): Collection;
    public function fetchEditors(): Collection;
    public function fetchViewers(): Collection;
}
