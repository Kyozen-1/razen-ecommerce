<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcDiscount extends Model
{
    use HasFactory;

    protected $table = 'ec_discounts';
    protected $guarded = 'id';

    public function ec_discount_product()
    {
        return $this->hasMany('App\Models\EcDiscountProduct', 'discount_id');
    }

    public function mp_store()
    {
        return $this->belongsTo('App\Models\MpStore', 'store_id');
    }
}
