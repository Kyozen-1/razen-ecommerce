<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductView extends Model
{
    use HasFactory;

    protected $table = 'ec_product_views';
    protected $guarded = 'id';

    public function product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
