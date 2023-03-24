<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductFile extends Model
{
    use HasFactory;

    protected $table = 'ec_product_files';
    protected $guarded = 'id';

    public function ec_product()
    {
        return $this->belongsTo('App\Models\EcProduct', 'product_id');
    }
}
