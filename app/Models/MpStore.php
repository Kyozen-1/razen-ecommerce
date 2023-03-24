<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpStore extends Model
{
    use HasFactory;

    protected $table = 'mp_store';
    protected $guarded = 'id';

    public function ec_product()
    {
        return $this->hasMany('App\Models\EcProduct', 'store_id');
    }
}
