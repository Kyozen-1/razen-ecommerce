<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcFlashSaleProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_flash_sale_products';
    protected $guarded = 'id';

    public function ec_flash_sale()
    {
        return $this->belongsTo('App\Models\EcFlashSale', 'flash_sale_id');
    }

    public function ec_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
