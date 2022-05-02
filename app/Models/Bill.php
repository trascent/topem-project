<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'number', 
        'emisor_name', 
        'emisor_nit', 
        'buyer_name', 
        'buyer_nit',
        'net_amount',
        'iva',
        'bill_purchase_date',
        'total_net_amount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'bill_purchase_date' => 'datetime',
    ];

    /**** Relaciones ****/

    /**
     * Retorna las compras de esa factura
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productPurchases()
    {
        return $this->hasMany(PurchasedProduct::class, 'bill_id');;
    }
}
