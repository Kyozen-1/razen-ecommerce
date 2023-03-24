<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcBrand extends Model
{
    use HasFactory;

    protected $table = 'ec_brands';
    protected $guarded = 'id';

    public function ec_product()
    {
        return $this->hasMany('App\Models\EcProduct', 'product_id');
    }
}
