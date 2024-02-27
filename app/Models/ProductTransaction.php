<?php
declare(strict_types=1);

namespace App\Models;

use App\Enums\ProductTransactionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => ProductTransactionTypeEnum::class,
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
