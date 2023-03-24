<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductTagProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_product_tag_products';
    protected $guarded = 'id';

    public function ec_product_tag()
    {
        return $this->belongsTo('App\Models\EcProductTag', 'tag_id');
    }

    public function ec_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
