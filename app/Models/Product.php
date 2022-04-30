<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'description', 
        'unit_price', 
    ];

    /**** Relaciones ****/

    /**
     * Retorna las compras de ese producto
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productPurchases()
    {
        return $this->hasMany(ProductPurchase::class, 'product_id');;
    }
}
