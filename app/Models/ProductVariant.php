<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "product_variants";

    protected $guarded = ['id','created_at','updated_at'];
}
