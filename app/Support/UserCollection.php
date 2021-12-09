<?php
namespace App\Support;

use Illuminate\Database\Eloquent\Collection;

class UserCollection extends Collection
{
    const ADMIN = 'Admin';
    const EDITOR = 'Editor';
    const VIEWER = 'Viewer';

    public function fetchAdmins(): Collection
    {
        return $this->where('name', self::ADMIN);
    }

    public function fetchEditors(): Collection
    {
        return $this->where('name', self::EDITOR);
    }

    public function fetchViewers(): Collection
    {
        return $this->where('name', self::VIEWER);
    }
}
