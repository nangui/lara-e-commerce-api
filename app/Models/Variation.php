<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Variation
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $slug
 * @property float $us_size
 * @property float $euro_size
 * @property float $uk_size
 * @property string $color_name
 * @property string $color_code
 * @property string $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Variation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variation newQuery()
 * @method static \Illuminate\Database\Query\Builder|Variation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Variation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereColorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereColorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereEuroSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereUkSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variation whereUsSize($value)
 * @method static \Illuminate\Database\Query\Builder|Variation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Variation withoutTrashed()
 * @mixin \Eloquent
 */
class Variation extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $guarded = ['id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
