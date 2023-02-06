<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $table = "products";

    protected $guarded = ['id','created_at','updated_at'];

    public function product_image()
    {
        return $this->hasOne(ProductImage::class, 'product_id');
    }

    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function product_variant_pricess()
    {
        return $this->hasOne(ProductVariantPrice::class, 'product_id');
    }

}
