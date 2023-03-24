<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcProductTag extends Model
{
    use HasFactory;

    protected $table = 'ec_product_tags';

    public function ec_product_tag_product()
    {
        return $this->belongsTo('App\Models\EcProductTag', 'tag_id');
    }
}
