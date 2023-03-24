<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductCollectionProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_product_collection_products';
    protected $guarded = 'id';

    public function ec_product_collection()
    {
        return $this->belongsTo('App\Models\EcProductCollection', 'product_collection_id');
    }

    public function ec_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
