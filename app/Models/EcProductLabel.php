<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductLabel extends Model
{
    use HasFactory;

    protected $table = 'ec_product_labels';
    protected $guarded = 'id';

    public function ec_product_label_products()
    {
        return $this->hasMany('App\Models\EcProductLabelProduct', 'product_label_id');
    }
}
