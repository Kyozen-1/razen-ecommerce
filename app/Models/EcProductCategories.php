<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductCategories extends Model
{
    use HasFactory;

    protected $table = 'ec_product_categories';
    protected $guarded = 'id';

    public function ec_product_category_product()
    {
        return $this->hasMany('App\Models\EcProductCategoryProduct', 'category_id');
    }
}
