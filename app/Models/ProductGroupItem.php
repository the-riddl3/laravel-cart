<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/***
 * @property int $item_id
 * @property ProductGroup $group
 * @property Product $product
 */
class ProductGroupItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';
    public $timestamps = false;
    protected $guarded = [];

    public function group(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'group_id', 'group_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
