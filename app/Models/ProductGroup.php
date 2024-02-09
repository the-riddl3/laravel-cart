<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/***
 * @property int $group_id
 * @property int $discount
 * @property User $user
 * @property Collection<ProductGroupItem> $groupItems
 */
class ProductGroup extends Model
{
    use HasFactory;

    protected $primaryKey = 'group_id';
    public $timestamps = false;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groupItems(): HasMany
    {
        return $this->hasMany(ProductGroupItem::class, 'group_id', 'group_id');
    }
}
