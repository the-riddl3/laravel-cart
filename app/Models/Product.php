<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/***
 * @property int $product_id
 * @property string $title
 * @property float $price
 * @property int $user_id
 * @property User $user
 */
class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $timestamps = false;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
