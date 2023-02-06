<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "product_variant_prices";

    protected $guarded = ['id','created_at','updated_at'];
}
