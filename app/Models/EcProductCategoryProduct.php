<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductCategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_product_category_product';
    protected $guarded = 'id';

    public function ec_product_categories()
    {
        return $this->belongsTo('App\Models\EcProductCategories', 'category_id');
    }

    public function ec_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
