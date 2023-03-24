<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductLabelProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_product_label_products';
    protected $guarded = 'id';

    public function ec_product_label()
    {
        return $this->belongsTo('App\Models\EcProductLabel', 'product_label_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
