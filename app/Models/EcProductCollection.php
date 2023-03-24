<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductCollection extends Model
{
    use HasFactory;

    protected $table = 'ec_product_collections';
    protected $guarded = 'id';

    public function ec_product_collection_product()
    {
        return $this->hasMany('App\Models\EcProductCollectionProduct', 'product_collection_id');
    }
}
