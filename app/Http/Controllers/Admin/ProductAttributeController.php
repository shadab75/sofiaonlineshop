<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributeController extends Controller
{
    //
    public function store($attributes,$product)
    {
        foreach ($attributes as $key=>$value){
            ProductAttribute::query()->create([
                'product_id'=>$product->id,
                'attribute_id'=>$key,
                'value'=>$value
            ]);
        }
    }

    public function update($attributeIds)
    {
       foreach ($attributeIds as $key=>$value){
        $productAttribute = ProductAttribute::query()->findOrFail($key);
           $productAttribute->update([
            'value'=>$value
           ]);
       }
    }

    public function change($attributes,$product)
    {
        ProductAttribute::query()->where('product_id',$product->id)->delete();
        foreach ($attributes as $key=>$value){
            ProductAttribute::query()->create([
                'product_id'=>$product->id,
                'attribute_id'=>$key,
                'value'=>$value
            ]);
        }
    }
}
