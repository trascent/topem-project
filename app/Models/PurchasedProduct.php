<?php

namespace App\Models;

use App\Models\Bill;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PurchasedProduct extends Pivot
{
    use HasFactory;

    protected $table = 'purchased_products';

    /**** Relaciones ****/
    
    /**
     * Retorna la factura correspondiente a la que pertenece
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id');;
    }

    /**
     * Retorna el producto comprado
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
