<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductUpSaleRelation extends Model
{
    use HasFactory;

    protected $table = 'ec_product_up_sale_relations';
    protected $guarded = 'id';

    public function from_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'from_product_id');
    }

    public function to_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'to_product_id');
    }
}
