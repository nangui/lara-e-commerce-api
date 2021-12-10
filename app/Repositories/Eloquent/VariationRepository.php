<?php

namespace App\Repositories\Eloquent;

use App\Models\Variation;
use App\Repositories\Contracts\IVariationRepository;

class VariationRepository extends BaseRepository implements IVariationRepository
{
    public function __construct(Variation $model)
    {
        parent::__construct($model);
    }
}
