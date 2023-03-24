<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcFlashSale extends Model
{
    use HasFactory;

    protected $table = 'ec_flash_sales';
    protected $guarded = 'id';

    public function ec_flash_sale_product()
    {
        return $this->hasMany('App\Models\EcFlashSaleProduct', 'flash_sale_id');
    }
}
