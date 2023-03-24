<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProduct extends Model
{
    use HasFactory;

    protected $table = 'ec_products';
    protected $guarded = 'id';

    public function ec_product_file()
    {
        return $this->hasMany('App\Models\EcProductFile', 'product_id');
    }

    public function ec_brand()
    {
        return $this->belongsTo('App\Models\EcBrand', 'brands_id');
    }

    public function ec_taxes()
    {
        return $this->belongsTo('App\Models\EcTaxes', 'tax_id');
    }

    public function ec_product_view()
    {
        return $this->hasMany('App\Models\EcProductView', 'product_id');
    }

    public function ec_product_variation()
    {
        return $this->hasMany('App\Models\EcProductVariation', 'product_id');
    }

    public function mp_store()
    {
        return $this->belongsTo('App\Models\MpStore', 'store_id');
    }

    public function ec_product_up_sale_relations_from_product()
    {
        return $this->hasMany('App\Models\EcProductUpSalesRelation', 'from_product_id');
    }

    public function ec_product_up_sale_relations_to_product()
    {
        return $this->hasMany('App\Models\EcProductUpSalesRelation', 'to_product_id');
    }

    public function ec_discount_product()
    {
        return $this->hasMany('App\Models\EcDiscountProduct', 'product_id');
    }

    public function ec_product_category_product()
    {
        return $this->hasMany('App\Models\EcProductCategoryProduct', 'product_id');
    }

    public function ec_product_label_product()
    {
        return $this->hasMany('App\Models\EcProductLabelProduct', 'product_id');
    }

    public function ec_flash_sale_product()
    {
        return $this->hasMany('App\Models\EcFlashSaleProduct', 'product_id');
    }

    public function ec_product_collection_product()
    {
        return $this->hasMany('App\Models\EcProductCollectionProduct', 'product_id');
    }

    public function ec_product_tag_product()
    {
        return $this->hasMany('App\Models\EcProductTagProduct', 'product_id');
    }
}
