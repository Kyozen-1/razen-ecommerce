<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcTaxes extends Model
{
    use HasFactory;

    protected $table = 'ec_taxes';
    protected $guarded = 'id';

    public function ec_product()
    {
        return $this->hasMany('App\Models\EcProduct', 'product_id');
    }
}
