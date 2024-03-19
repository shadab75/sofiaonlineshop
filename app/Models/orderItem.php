<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderItem extends Model
{
    protected $table = "order_items";
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variation()
    {
        return $this->belongsTo(ProductVariation::class,'product_variation_id');
    }

}
