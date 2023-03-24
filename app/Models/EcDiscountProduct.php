<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcDiscountProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_discount_products';
    protected $guarded = 'id';

    public function ec_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }

    public function ec_discount()
    {
        return $this->belongsTo('App\Models\EcDiscount', 'discount_id');
    }
}
